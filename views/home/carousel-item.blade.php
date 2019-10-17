<li data-target="#news-carousel" data-slide-to="{{$i}}" class="{{$i == 0 ? 'active' : '' }}">
    <div class="d-none d-lg-flex align-items-center">
        <div class="slide-img">
            {{the_post_thumbnail('medium', ['class' => 'object-fit-image', 'alt' => get_the_title()])}}
        </div>
        <div class="title title-line-cap">@title</div>
    </div>
</li>