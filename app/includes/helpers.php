<?php

//cool functions for development

function pre($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

function path()
{
    return get_template_directory_uri() . '/';
}

function tel($phone)
{
    return 'tel:' . preg_replace('/[^0-9]/', '', $phone);
}

function the_post_content()
{
    global $id;
    echo apply_filters('the_content', wpautop(get_post_field('post_content', $id), true));
}

function the_image($name, $class = '', $post = null, $size = 'full')
{
    if ($post == null) {
        global $post;
    }

    $image = get_field($name);

    echo wp_get_attachment_image($image, $size, false, ['class' => $class]);
}

function the_icon($name, $echo = true)
{
    $icon = file_get_contents(path() . "assets/img/icons/$name.svg");
    if ($echo) {
        echo $icon;
        return;
    }
    return file_get_contents(path() . "assets/img/icons/$name.svg");
}

function the_checkbox($field, $print, $post = null)
{
    if ($post == null) {
        global $post;
    }
    echo get_field($field, $post) ? $print : null;
}

function the_table($field, $post = null)
{
    if ($post == null) {
        global $post;
    }
    $table = get_field($field, $post);
    if ($table) {
        echo '<table>';
        if ($table['header']) {
            echo '<thead>';
            echo '<tr>';
            foreach ($table['header'] as $th) {
                echo '<th>';
                echo $th['c'];
                echo '</th>';
            }
            echo '</tr>';
            echo '</thead>';
        }
        echo '<tbody>';
        foreach ($table['body'] as $tr) {
            echo '<tr>';
            foreach ($tr as $td) {
                echo '<td>';
                echo $td['c'];
                echo '</td>';
            }
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }
}

function the_link($field, $post = null, $classes = "")
{
    if ($post == null) {
        global $post;
    }
    $link = get_field($field, $post);
    if ($link) {
        echo "<a ";
        echo "href='{$link['url']}'";
        echo "class='$classes'";
        echo "target='{$link['target']}'>";
        echo $link['title'];
        echo "</a>";
    }
}

function repeater_image($name)
{
    echo 'src="' . get_sub_field($name)['url'] . '" ';
    echo 'alt="' . get_sub_field($name)['alt'] . '" ';
}

function front_id()
{
    return get_option('page_on_front');
}

/**
 * @return WP_Term[]
 */
function post_categories($post = null): array
{
    if ($post == null) {
        global $post;
    }
    return wp_get_post_categories(get_the_ID(), [
        'exclude' => [get_queried_object_id(), get_field('blog_category', front_id())->term_id]
    ]);
}

function the_option($name, $page = 'option')
{
    echo get_field($name, $page);
}

function view($view, $args = null, $folder = 'views')
{
    if (!empty($args) && is_array($args)) {
        extract($args); // @codingStandardsIgnoreLine
    }
    include get_template_directory() . "/$folder/$view.php";
}

function time_diff($post = null): string
{
    if ($post == null) {
        global $post;
    }
    return human_time_diff(get_post_time('U'), current_time('timestamp')) . ' назад';
}

function get_views(WP_Post $post = null): int
{
    if ($post == null) {
        global $post;
    }

    $id = $post->ID;
    $metaKey = 'post_views_count';
    $count = get_post_meta($id, $metaKey, true);
    if ($count == '') {
        $count = 1;
        delete_post_meta($id, $metaKey);
        add_post_meta($id, $metaKey, 1);
    } else {
        $count++;
        update_post_meta($id, $metaKey, $count);
    }
    return $count;
}

function asset(string $path)
{
    return path() . 'assets/' . $path;
}

function wp_get_document_title_fixed() {

    /**
     * Filters the document title before it is generated.
     *
     * Passing a non-empty value will short-circuit wp_get_document_title(),
     * returning that value instead.
     *
     * @since 4.4.0
     *
     * @param string $title The document title. Default empty string.
     */
    $title = '';
    if ( ! empty( $title ) ) {
        return $title;
    }

    global $page, $paged;

    $title = array(
        'title' => '',
    );

    // If it's a 404 page, use a "Page not found" title.
    if ( is_404() ) {
        $title['title'] = __( 'Page not found' );

        // If it's a search, use a dynamic search results title.
    } elseif ( is_search() ) {
        /* translators: %s: search phrase */
        $title['title'] = sprintf( __( 'Search Results for &#8220;%s&#8221;' ), get_search_query() );

        // If on the front page, use the site title.
    } elseif ( is_front_page() ) {
        $title['title'] = get_bloginfo( 'name', 'display' );

        // If on a post type archive, use the post type archive title.
    } elseif ( is_post_type_archive() ) {
        $title['title'] = post_type_archive_title( '', false );

        // If on a taxonomy archive, use the term title.
    } elseif ( is_tax() ) {
        $title['title'] = single_term_title( '', false );

        /*
        * If we're on the blog page that is not the homepage or
        * a single post of any post type, use the post title.
        */
    } elseif ( is_home() || is_singular() ) {
        $title['title'] = single_post_title( '', false );

        // If on a category or tag archive, use the term title.
    } elseif ( is_category() || is_tag() ) {
        $title['title'] = single_term_title( '', false );

        // If on an author archive, use the author's display name.
    } elseif ( is_author() && $author = get_queried_object() ) {
        $title['title'] = $author->display_name;

        // If it's a date archive, use the date as the title.
    } elseif ( is_year() ) {
        $title['title'] = get_the_date( _x( 'Y', 'yearly archives date format' ) );

    } elseif ( is_month() ) {
        $title['title'] = get_the_date( _x( 'F Y', 'monthly archives date format' ) );

    } elseif ( is_day() ) {
        $title['title'] = get_the_date();
    }

    // Add a page number if necessary.
    if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
        $title['page'] = sprintf( __( 'Page %s' ), max( $paged, $page ) );
    }

    // Append the description or site title to give context.
    if ( is_front_page() ) {
        $title['tagline'] = get_bloginfo( 'description', 'display' );
    } else {
        $title['site'] = get_bloginfo( 'name', 'display' );
    }

    /**
     * Filters the separator for the document title.
     *
     * @since 4.4.0
     *
     * @param string $sep Document title separator. Default '-'.
     */
    $sep = apply_filters( 'document_title_separator', '-' );

    /**
     * Filters the parts of the document title.
     *
     * @since 4.4.0
     *
     * @param array $title {
     *     The document title parts.
     *
     *     @type string $title   Title of the viewed page.
     *     @type string $page    Optional. Page number if paginated.
     *     @type string $tagline Optional. Site description when on home page.
     *     @type string $site    Optional. Site title when not on home page.
     * }
     */
    //  $title = apply_filters( 'document_title_parts', $title );

    $title = implode( " $sep ", array_filter( $title ) );
    $title = wptexturize( $title );
    $title = convert_chars( $title );
    $title = esc_html( $title );
    $title = capital_P_dangit( $title );

    return $title;
}