@php $link = get_permalink() @endphp
<article class="article-item">
    <a href="@link" class="article-img">
        @if (has_post_thumbnail())
            {{the_post_thumbnail('article', ['class' => 'object-fit-image', 'alt' => get_the_title()])}}
        @else
            <img src="{{asset('img/404-img.jpg')}}" alt="no image" class="object-fit-image">
        @endif
    </a>
    <div class="article-body">
        <a href="@link" class="article-title title-line-cap title">@title</a>
        <div class="article-date">
            <img src="{{asset('img/icons/clocknews.svg')}}" alt="clocknews" class="mr-2">
            <span>{{time_diff()}}</span>
        </div>
        <div class="article-description title-line-cap">@excerpt</div>
        <a href="@link" class="button btn-silver b-sm">ЧИТАТЬ ДЕТАЛЬНЕЕ</a>
    </div>
</article>