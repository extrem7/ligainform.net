<?php
/* @var $category WP_Term
 * @var $wrapper_class string
 * @var $big_class string
 * @var $additional_class string
 */
?>
@php
    global $post;
    $posts = get_posts([
        'posts_per_page' => 4,
        'category' => $category->term_id
    ]);
@endphp
<div class="news-item {{$wrapper_class}}">
    <a href="{{get_category_link($category)}}"
       class="title text-uppercase title-category cat-{{$category->slug}}">
        <span>{{$category->name}}</span>
    </a>
    <div class="row">
        @php $post = array_shift($posts) @endphp
        @include('home.article-big', ['big_class' => $big_class])
        @reset_query
        <div class="col-12 {{$additional_class}} additional-news">
            @foreach ($posts as $post)
                @include('home.article')
            @endforeach
            @reset_query
        </div>
    </div>
</div>