<?php

class ThemeBase
{
    protected function __construct()
    {
        $this->themeSetup();
        $this->enqueueStyles();
        $this->enqueueScripts();
        $this->customHooks();
        $this->GPSI();
        $this->categoryQuery();
        $this->auth();
        $this->feed();
        $this->registerWidgets();
        $this->ACF();
    }

    private function themeSetup()
    {
        add_theme_support('post-thumbnails');
        add_theme_support('menus');
        add_theme_support('widgets');
        show_admin_bar(false);
    }

    private function enqueueStyles()
    {
        add_action('wp_print_styles', function () {
            wp_register_style('main', path() . 'assets/css/main.css');
            wp_enqueue_style('main');
        });
        add_action('admin_enqueue_scripts', function () {
            //wp_enqueue_style('admin-styles', get_template_directory_uri() . '/assets/css/admin.css');
        });
    }

    private function enqueueScripts()
    {
        add_action('wp_enqueue_scripts', function () {
            /* wp_deregister_script('jquery');
             wp_register_script('jquery', path() . 'assets/node_modules/jquery/dist/jquery.min.js');
             wp_enqueue_script('jquery');
 */
            wp_register_script('popper', path() . 'assets/node_modules/popper.js/dist/umd/popper.min.js');
            wp_enqueue_script('popper');
            wp_register_script('bootstrap', path() . 'assets/node_modules/bootstrap/dist/js/bootstrap.min.js');
            wp_enqueue_script('bootstrap');

            wp_register_script('fancybox', path() . 'assets/node_modules/@fancyapps/fancybox/dist/jquery.fancybox.min.js');
            wp_enqueue_script('fancybox');

            wp_register_script('main', path() . 'assets/js/main.js');
            wp_enqueue_script('main');
            wp_localize_script('main', 'SharedData',
                ['adminAjax' => admin_url('admin-ajax.php')]
            );
        });
    }

    private function customHooks()
    {
        add_action('admin_init', function () {
            global $user_ID;
            if (!current_user_can('administrator')) {
                remove_menu_page('tools.php');
                remove_menu_page('themes.php');
                remove_menu_page('edit-comments.php');
                remove_menu_page('plugins.php');
                remove_menu_page('users.php');
                remove_menu_page('options-general.php');
            }
        });
        add_filter('nav_menu_css_class', function ($classes, $item) {
            if (in_array('current-menu-item', $classes)) {
                $classes[] = 'active ';
            }
            return $classes;
        }, 10, 2);
        add_action('navigation_markup_template', function ($content) {
            $content = str_replace('role="navigation"', '', $content);
            $content = preg_replace('#<h2.*?>(.*?)<\/h2>#si', '', $content);

            return $content;
        });
        add_image_size('article', 320, 220, ['center', 'center']);
        add_image_size('article_big', 600, 300, ['center', 'center']);
        add_filter('wpcf7_form_elements', function ($content) {
            // pre($content);
            $content = preg_replace('/<br \/>/', '', $content);
            return $content;
        });
        add_filter('body_class', function ($classes) {
            return $classes;
        });
        add_action('template_redirect', function () {
        });
        add_action('pre_get_posts', function (WP_Query $query) {
            if (!is_admin() && $query->is_search() && $query->is_main_query()) {
                $query->set('post_type', 'post');
            }
        });
        add_filter('comment_reply_link', function ($link) {
            if (empty ($GLOBALS['user_ID']) && get_option('comment_registration')) {
                return '';
            }

            return $link;
        });
        add_action('wp_logout', function () {
            wp_redirect(home_url());
            exit();
        });
        add_filter('comment_text', function ($text) {
            return '<div class="comment-text mb-2">' . $text . '</div><div class="d-flex align-items-center justify-content-between">';
        }, 33);
    }

    private function ACF()
    {
        if (function_exists('acf_add_options_page')) {
            $main = acf_add_options_page([
                'page_title' => 'Настройки',
                'menu_title' => 'Настройки',
                'menu_slug' => 'theme-general-settings',
                'capability' => 'edit_posts',
                'redirect' => false,
                'position' => 2,
                'icon_url' => 'dashicons-hammer',
            ]);
        }

        $path = get_template_directory() . '/assets/acf-json';
        add_filter('acf/settings/save_json', function () use ($path) {
            return $path;
        });
        add_filter('acf/settings/load_json', function () use ($path) {
            return [$path];
        });
    }

    private function GPSI()
    {
        add_action('after_setup_theme', function () {
            remove_action('wp_head', 'wp_print_scripts');
            remove_action('wp_head', 'wp_print_head_scripts', 9);
            remove_action('wp_head', 'wp_enqueue_scripts', 1);
            add_action('wp_footer', 'wp_print_scripts', 5);
            add_action('wp_footer', 'wp_enqueue_scripts', 5);
            add_action('wp_footer', 'wp_print_head_scripts', 5);
            remove_action('wp_head', 'wp_generator');
            remove_action('wp_head', 'wlwmanifest_link');
            remove_action('wp_head', 'rsd_link');
            remove_action('wp_head', 'wp_shortlink_wp_head');
            remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
            add_filter('the_generator', '__return_false');
            remove_action('wp_head', 'print_emoji_detection_script', 7);
            remove_action('wp_print_styles', 'print_emoji_styles');
        });
        add_action('wp_print_styles', function () {
            wp_deregister_style('dashicons');
        }, 100);
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'wp_oembed_add_host_js');
    }

    private function categoryQuery()
    {
        add_action('pre_get_posts', function (WP_Query $query) {
            if (!is_admin() && $query->is_category() && $query->is_main_query()) {
                $ppp = get_option('posts_per_page');;
                $offset = 1;

                if (!$query->is_paged()) {
                    $query->set('posts_per_page', $ppp + $offset);
                } else {
                    $offset = (($query->query_vars['paged'] - 1) * $ppp) + $offset;
                    $query->set('posts_per_page', $ppp);
                    $query->set('offset', $offset);
                }
            }
        });
        add_filter('found_posts', function (int $found_posts, WP_Query $query) {
            $ppp = get_option('posts_per_page');
            $first_page_ppp = $ppp + 1;

            if ($query->is_category() && $query->is_main_query()) {
                if (!is_paged()) {
                    return ($first_page_ppp + ($found_posts - $first_page_ppp) * $first_page_ppp / $ppp);
                } else {
                    return ($found_posts - ($first_page_ppp - $ppp));
                }
            }
            return $found_posts;
        }, 10, 2);
    }

    private function auth()
    {
        add_action('login_enqueue_scripts', function () {
            wp_enqueue_style('auth', path() . 'assets/css/admin.css', false);
        }, 10);
        add_action('check_admin_referer', function ($action, $result) {
            if ($action == "log-out" && !isset($_GET['_wpnonce'])) {
                $redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : '/';
                $location = str_replace('&amp;', '&', wp_logout_url($redirect_to));
                header("Location: $location");
                die;
            }
        }, 10, 2);
        add_filter('login_message', function ($message) {
            if (empty($message)) {
                echo "<div class='politics'>
<span>Предупреждение:</span> незаконное вмешательство в работу <br/> системы влечет за собой уголовную ответсвенность,<br/>
предусмотренную ст.361, ст.362 и ст.371 Уголовного <br/> кодекса Украины
</div>";
            } else {
                echo $message;
            }
        });
    }

    private function feed()
    {
        add_filter('excerpt_length', function ($length) {
            return 40;
        });

        add_filter('excerpt_more', function ($more) {
            return '...';
        });

        add_filter('the_category_rss', function ($the_list) {

            $categories = get_the_category();
            $category = $categories[0]->name;

            $the_list = esc_html("$category");

            return $the_list;
        });

        remove_all_actions('do_feed_rss2');
        add_action('do_feed_rss2', function ($for_comments) {
            $rss_template = get_template_directory() . '/views/feed.php';
            if (file_exists($rss_template)) {
                load_template($rss_template);
            } else {
                do_feed_rss2($for_comments);
            }
        }, 10, 1);

        add_filter('the_excerpt_rss', function ($content) {
            $img = get_the_post_thumbnail(null, [100, 80], ['align' => 'left', 'style' => 'margin-right:15px;']);
            $content = $img . $content;

            return $content;
        });
    }

    private function registerWidgets()
    {
        add_action('widgets_init', function () {
            register_sidebar([
                'name' => "Правая панель главной страницы",
                'id' => 'home-right-sidebar',
                'description' => 'Эти виджеты будут показаны в правой колонке сайта',
                'before_widget' => '<div class="widget widget_democracy">',
                'after_widget' => "</div>\n",
                'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>'
            ]);
        });
    }
}