<? /* @var $title string */ ?>
@extends('layouts.base')
@section('content')
    <h1 class="search-title mb-3">{{$title}}</h1>
    @if (is_page())
        <h1 class="title text-uppercase title-category cat-news mb-lg-5 mb-3 cat-world">
            <span>@title</span>
        </h1>
    @endif
    <div class="row">
        <div class="col-xl-9 ">
            @php league()->allNews() @endphp
            @if (have_posts())
                <div class="article-list">
                    @while (have_posts())
                        @php the_post() @endphp
                        @include('articles.includes.item')
                    @endwhile
                </div>
            @endif
            {!! league()->pagination() !!}
            @include('includes.banner')
        </div>
        <div class="col-xl-3 d-none d-xl-block">
            <div class="banner-site-pc">
                {!!league()->ads()!!}
            </div>
        </div>
    </div>
@endsection