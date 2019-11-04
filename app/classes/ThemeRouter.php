<?php
require_once get_template_directory() . "/vendor/autoload.php";
require_once get_template_directory() . "/app/controllers/Controller.php";

use Jenssegers\Blade\Blade;

class ThemeRouter
{
    private $blade;

    public function __construct()
    {
        $this->blade = new Blade(get_template_directory() . '/views', get_template_directory() . '/cache');
        $this->directives();
        add_filter('theme_page_templates', [$this, 'pageTemplates']);
        add_filter('template_include', [$this, 'routes']);
    }

    public function render(string $view, array $args = [], bool $echo = true)
    {
        $blade = new Blade(__dir__ . '/src/views', __dir__ . '/cache');
        $html = $this->blade->make($view, $args);
        if ($echo) {
            echo $html;
        } else {
            return $html;
        }
    }

    private function directives(): void
    {
        $this->blade->directive('title', function () {
            return "<?php the_title() ?>";
        });
        $this->blade->directive('content', function () {
            return "<?php the_post_content(); ?>";
        });
        $this->blade->directive('link', function () {
            return "<?php the_permalink() ?>";
        });
        $this->blade->directive('excerpt', function () {
            return "<?php the_excerpt() ?>";
        });
        $this->blade->directive('reset_query', function () {
            return "<?php wp_reset_query(); ?>";
        });
        $this->blade->directive('option', function ($field) {
            return "<?php the_option('$field'); ?>";
        });
        $this->blade->directive('row', function ($option) {
            return "<?php while(have_rows($option)):the_row(); ?>";
        });
        $this->blade->directive('rowend', function ($option) {
            return "<?php endwhile; ?>";
        });
        $this->blade->directive('icon', function ($icon) {
            return the_icon($icon, false);
        });
        $this->blade->directive('logged', function () {
            return "<?php if(is_user_logged_in()): ?>";
        });
    }

    public function pageTemplates(array $post_templates): array
    {
        $pages = array_diff(scandir(get_template_directory() . '/views/pages/'), ['.', '..']);
        foreach ($pages as $page) {
            $template_contents = file_get_contents(get_template_directory() . '/views/pages/' . $page);
            preg_match_all("/Template Name:(.*)\n/siU", $template_contents, $template_name);
            $template_name = trim($template_name[1][0]);
            $template_name = str_replace(' */ ?>', '', $template_name);
            if ($template_name) $post_templates["views/pages/$page"] = $template_name;
        }
        return $post_templates;
    }

    public function routes(string $template)
    {
        global $post;
        $view = '';
        $data = [];
        if (is_front_page()) {
            $data = Controller::home();
        }
        if (is_archive()) {
            if (is_category()) {
                $slug = get_queried_object()->slug;
                $data = compact('slug');
                $view = 'articles/category';
            } else {
                $data = Controller::archive();
                $view = 'articles/archive';
            }
        }
        if (is_search()) {
            $data = Controller::archive();
            $view = 'articles/archive';
        }
        if (is_single()) {
            switch (get_post_type()) {
                case 'post':
                    $data = Controller::single($post);
                    $view = 'articles/single';
                    break;
                case 'member':
                    $view = 'members/single';
                    break;
            }
        }
        if (is_404()) {
            $view = 'errors/404';
        }
        if (is_page() && !get_page_template_slug()) {
            $view = 'page';
        }
        if ($view === '') {
            $view = explode('views/', $template)[1];
            $view = str_replace('.php', '', $view);
            $view = str_replace('.blade', '', $view);
        }
        $this->render($view, $data);
        return null;
    }
}