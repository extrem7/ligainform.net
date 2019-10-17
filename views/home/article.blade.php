@php global $post @endphp
<div class="d-flex align-items-center additional-item">
    <a href="@link"
       class="news-image">{{the_post_thumbnail('medium', ['class' => 'object-fit-image', 'alt' => get_the_title()])}}
    </a>
    <div>
        <a href="@link" class="title title-line-cap">@title</a>
        <div class="article-date">
            <img src="{{asset('img/icons/clock-circular-outline.svg')}}" alt="time-news" class="mr-2"> {{time_diff()}}
        </div>
    </div>
</div>