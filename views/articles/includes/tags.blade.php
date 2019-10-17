@if (has_tag())
    <div class="d-flex align-items-center article-tags">
        <div>ТЕГИ:</div>
        <div>
            @foreach (wp_get_post_tags(get_the_ID()) as $tag)
                <a href="{{get_tag_link($tag)}}" class="tag">{{$tag->name}}</a>
            @endforeach
        </div>
    </div>
@endif