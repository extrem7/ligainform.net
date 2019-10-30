<?php

class Controller
{
    public static function home(): array
    {
        $news = get_posts([
            'posts_per_page' => 4,
            'meta_key' => 'top_post_on_home',
            'meta_value' => true
        ]);
        $rows = get_categories([
            'exclude' => [1, 29, 70]
        ]);
        $columns = get_categories([
            'include' => [29, 70]
        ]);
        return compact('news', 'rows', 'columns');
    }

    public static function archive(): array
    {
        $title = is_search() ? ('Результаты поиска «' . $_GET['s'] . '»') : single_tag_title(null, false);
        return compact('title');
    }

    public static function single(WP_Post $post): array
    {
        $comments = get_comments([
            'post_id' => $post->ID,
        ]);
        return compact('comments');
    }
}