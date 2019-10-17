<a href="@link" class="carousel-item {{$i == 0 ? 'active' : '' }}">
    {{the_post_thumbnail('large', ['class' => 'object-fit-image', 'alt' => get_the_title()])}}
    <div class="caption">
        <div class="title title-line-cap">@title</div>
        <div class="article-date">
            <img src="{{asset('img/icons/clock-white.svg')}}" alt="times-article" class="mr-2"> {{time_diff()}}
        </div>
    </div>
</a>
