@php
    the_post();
    $link = get_permalink();
@endphp
<div class="col-xl-5 col-lg-4 pr-lg-0">
    <div class="archive-box">
        <div class="archive-info">
            <div class="archive-name title text-uppercase">
                <div class="d-flex align-items-center">
                    <span>{{single_cat_title()}}</span>
                </div>
            </div>
        </div>
        <div class="article-info">
            <div class="title article-title title-line-cap">@title</div>
            <div class="decor-line"></div>
            <div class="article-date">
                <img src="{{asset('img/icons/clocknews-dark.svg')}}" alt="clocknews" class="mr-2">
                <span>{{time_diff()}}</span>
            </div>
            <div class="article-description title-line-cap">@excerpt</div>
            <a href="@link" class="button btn-silver-dark">ЧИТАТЬ ДЕТАЛЬНЕЕ</a>
        </div>
    </div>
</div>
<div class="col-xl-7 col-lg-8 pl-lg-0">
    <a href="@link" class="d-block article-img">
        {{the_post_thumbnail('post-thumbnail', ['class' => 'object-fit-image', 'alt' => get_the_title()])}}
    </a>
</div>