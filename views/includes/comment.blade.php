@php
    /*
     * @var $comment WP_Comment
     * @var $avatar string
     * @var $reply_url string
     */
@endphp
<li class="comment" id="comment-{{ $comment->comment_ID }}">
    <div class="comment-container">
        <div class="avatar">
            {!! $avatar !!}
        </div>
        <div class="comment-wrapper">
            <div class="d-flex align-items-center justify-content-between">
                <div class="name">{{ $comment->comment_author }}</div>
                <div class="date ml-2">{{ get_comment_date(get_option('date_format')) }}
                    | {{ get_comment_time(get_option('time_format')) }}</div>
            </div>
            @php comment_text() @endphp
            <div class="d-flex align-items-center justify-content-between">
                <a rel="nofollow" class="comment-reply-link" href="{{ $reply_url }}">Ответить</a>
            </div>
        </div>
        {!! '</div>'!!}
    </div>
</li>