<?php
/* @var $main array
 * @var $thumbnails array[]
 */ ?>
<div class="gallery-single">
    <a class="gallery-main-photo" data-fancybox="images" href="{{$main['url']}}">
        <img src="{{$main['url']}}" alt>
    </a>
    <div class="gallery-thumb">
        @foreach($thumbnails as $thumbnail)
            <a href="{{$thumbnail['url']}}" data-fancybox="images" class="thumb-item">
                <img src="{{$thumbnail['sizes']['thumbnail']}}" alt="">
            </a>
        @endforeach
    </div>
</div>