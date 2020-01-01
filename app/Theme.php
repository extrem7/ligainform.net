<?php

require_once "includes/helpers.php";
require_once "classes/ThemeBase.php";
require_once 'classes/ThemeRouter.php';

class Theme extends ThemeBase
{
    private static $instance;

    public $router;

    public static function getInstance(): Theme
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    protected function __construct()
    {
        $this->router = new ThemeRouter();
        $this->shortCodes();
        parent::__construct();
        add_action('init', function () {
            //$this->registerTaxonomies();
            $this->registerPostTypes();
        });
        //$this->exchange();
        //add_action('wp_ajax_action', [$this, 'method']);
        //add_action('wp_ajax_nopriv_action', [$this, 'method']);
    }

    public function pagination(): string
    {
        return get_the_posts_pagination([
            'show_all' => false,
            'end_size' => 3,
            'mid_size' => 3,
            'prev_next' => true,
            'prev_text' => '<',
            'next_text' => '>',
        ]);
    }

    public function allNews(): void
    {
        if (is_page()) {
            global $wp_query;
            $wp_query = new WP_Query([
                'post_type' => 'post',
                'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1
            ]);
        }
    }

    public function exchange(): array
    {
        if ($string = file_get_contents('http://bank-ua.com/export/currrate.xml')) {
            $xml = new SimpleXMLElement($string);
            $xml = json_decode(json_encode($xml), TRUE);
            $currencies = array_filter($xml['item'], function ($item) {
                return in_array($item['char3'], ['USD', 'EUR']);
            });
            foreach ($currencies as $item) {
                update_option($item['char3'] . '_CHANGE', $item['change'] > 0 ? 'up' : 'down');
            }
        }
        $rates = [];
        $request = 'https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=5';

        if ($json = file_get_contents($request)) {
            $rawRates = json_decode($json, true);
            $filtered = array_filter($rawRates, function ($rate) {
                return in_array($rate['ccy'], ['USD', 'EUR']);
            });
            foreach ($filtered as $rate) {
                $buy = round($rate['buy'], 4);
                $sale = round($rate['sale'], 4);
                $rates[$rate['ccy']] = "$buy / $sale";
            };
            foreach ($rates as $ccy => $rate) update_option($ccy, $rate);
        }
        return $rates;
    }

    public function ads(string $size = '300x600'): string
    {
        return get_field("ads_$size", 'option');
    }

    public function comments()
    {
        return new class($this->router)
        {
            private $router;

            public function __construct($router)
            {
                $this->router = $router;
            }

            public function list($comments)
            {
                wp_list_comments([
                    'callback' => function (WP_Comment $comment) {
                        $avatar = $this->avatar();
                        $reply_url = $this->reply_url($comment);
                        $this->router->render('includes/comment', compact('comment', 'avatar', 'reply_url'));
                    }
                ], $comments);
            }

            public function form()
            {
                comment_form([
                    'comment_field' => ' <p><textarea name="comment" id="comment" class="control-form" rows="10" cols="50" tabindex="4"></textarea></p>',
                    'class_submit' => 'button-comment',
                    'title_reply_before' => null,
                    'title_reply' => null,
                    'title_reply_after' => null
                ]);
            }

            private function reply_url(WP_Comment $comment)
            {
                return esc_url(
                        add_query_arg(
                            [
                                'replytocom' => $comment->comment_ID,
                                'unapproved' => false,
                                'moderation-hash' => false,
                            ]
                        )
                    ) . '#comment';
            }

            private function avatar()
            {
                $email = get_comment_author_email();
                $avatar = str_replace("class='avatar", "class='photo avatar", get_avatar("$email", 60));
                return $avatar;
            }
        };
    }

    private function shortCodes()
    {
        add_shortcode('gallery', function () {
            if ($gallery = get_field('gallery')) {
                $data = [
                    'main' => array_shift($gallery),
                    'thumbnails' => $gallery
                ];
                return $this->router->render('articles.includes.gallery', $data, false);
            } else {
                return 'Нет галереи';
            }
        });
    }

    private function registerPostTypes(): void
    {
        register_post_type(
            'member',
            [
                'label' => null,
                'labels' => [
                    'name' => 'Удостоверения',
                    'singular_name' => 'Удостоверения',
                    'add_new' => 'Добавить удостоверение',
                    'add_new_item' => 'Добавление удостоверения',
                    'edit_item' => 'Редактирование удостоверения',
                    'new_item' => '',
                    'view_item' => 'Смотреть удостоверение',
                    'search_items' => 'Искать удостоверение',
                    'not_found' => 'Не найдено',
                    'not_found_in_trash' => 'Не найдено в корзине',
                    'menu_name' => 'Удостоверения',
                ],
                'public' => true,
                'menu_position' => 5,
                'menu_icon' => 'dashicons-businessman',
                'capabilities' => [
                    'edit_post' => 'update_core',
                    'read_post' => 'update_core',
                    'delete_post' => 'update_core',
                    'edit_posts' => 'update_core',
                    'edit_others_posts' => 'update_core',
                    'delete_posts' => 'update_core',
                    'publish_posts' => 'update_core',
                    'read_private_posts' => 'update_core'
                ],
                'supports' => ['title', 'custom-fields', 'thumbnail'],
                'has_archive' => false,
                'rewrite' => ['slug' => 'members-sotrudnyki']]);
    }

}
