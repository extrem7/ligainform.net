<?php /* @var $big_class string */ ?>
<div class="col-12 {{$big_class}} main-last-news">
    <a href="@link" class="news-image">
        {{the_post_thumbnail('article_big', ['class' => 'object-fit-image', 'alt' => get_the_title()])}}
    </a>
    <a href="@link" class="title title-line-cap">@title</a>
    <div class="article-date">
        <img src="{{asset('img/icons/clock-circular-outline.svg')}}" alt="time-news" class="mr-2"> {{time_diff()}}
    </div>
    <div class="short-description title-line-cap">@excerpt</div>
</div>