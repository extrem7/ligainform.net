<? /* @var $slug string */ ?>
@extends('layouts.base')
@section('content')
    @if (!is_paged())
        <div class="archive-main-article">
            <div class="row">
                @include('articles.includes.item-main')
            </div>
        </div>
    @else
        <h1 class="title text-uppercase title-category cat-news mb-lg-5 mb-3 cat-{{$slug}}">
            <span>{{ single_cat_title() }}</span></h1>
    @endif
    <div class="row">
        <div class="col-xl-9 ">
            <div class="banner-archive-top">
                <div class="banner-site-pc">
                    {!!league()->ads('728x90')!!}
                </div>
                <div class="banner-site-mob">
                    {!!league()->ads('300x250')!!}
                </div>
            </div>
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