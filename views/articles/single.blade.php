@extends('layouts.base')
@section('content')
    @php global $post @endphp
    <div class="row">
        <div class="col-xl-9 ">
            <article class="single-article">
                <div class="single-header">
                    <h1 class="title">@title</h1>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="single-date">
                            <img src="{{asset('img/icons/clocknews.svg')}}" class="mr-2"
                                 alt="clock">{{get_the_date('d F Y | H:m')}}
                        </div>
                        <div class="single-views">
                            <img src="{{asset('img/icons/eye.svg')}}" alt="views"
                                 class="mr-2">{{get_views()}}
                        </div>
                    </div>
                    @if (has_post_thumbnail())
                        <div class="single-image">
                            {{the_post_thumbnail('full', ['alt' => get_the_title()])}}
                            @if (get_the_post_thumbnail_caption())
                                <div class="caption-image">&#169 {{the_post_thumbnail_caption()}}</div>
                            @endif;
                        </div>
                    @endif
                </div>
                <div class="single-body dynamic-content">@content</div>
            </article>
            @include('articles.includes.telegram')
            @include('articles.includes.tags')
            {!!do_shortcode('[TheChamp-Sharing]')!!}
            <div class="site-error-text mt-4">Если вы заметили ошибку, выделите необходимый текст и нажмите
                Ctrl+Enter, чтобы сообщить нам об этом
            </div>
            @include('includes.banner')
            <div class="news-partner">
                @option(partner_news)
            </div>
            <div class="comments" id="comments">
                @logged
                <div class="comments-title title">Комментарии:</div>
                {{ league()->comments()->form() }}
                @else
                    <a href="#" class="btn-comment" data-target="#loginModal" data-toggle="modal">КОММЕНТИРОВАТЬ</a>
                @endif
                @empty($comments)
                    <p class="nocomments">Пока комментариев нет</p>
                @else
                    <ol class="commentlist">
                        {{ league()->comments()->list($comments) }}
                    </ol>
                @endif
            </div>
            @include('includes.banner')
        </div>
        <div class="col-xl-3 d-none d-xl-block">
            @include('articles.includes.last-items')
            <div class="banner-site-pc mt-5">
                {!!league()->ads() !!}
            </div>
        </div>
    </div>
@endsection