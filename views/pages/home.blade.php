<? /* Template Name: Главная */ ?>
<?
/* @var $news WP_Post[]
 * @var $rows WP_Term[]
 * @var $columns WP_Term[]
 */
global $post;
?>
@extends('layouts.base')
@section('content')
    @isset($news)
        <div class="news-carousel">
            <div id="news-carousel" class="carousel slide" data-ride="carousel" data-interval="10000">
                <div class="carousel-inner">
                    @for ($i = 0; $i < count($news); $i++)
                        @php $post = $news[$i] @endphp
                        @include('home.carousel-main',compact('i'))
                    @endfor
                    @reset_query
                    <a class="carousel-control-prev" href="#news-carousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#news-carousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                <div class="nav-slider">
                    <ol class="nav">
                        @for ($i = 0; $i < count($news); $i++)
                            @php $post = $news[$i] @endphp
                            @include('home.carousel-item',compact('i'))
                        @endfor
                        @reset_query
                    </ol>
                </div>
            </div>
        </div>
    @endisset
    <div class="banner-home-top">
        <div class="banner-site-pc">
            {{league()->ads('728x90')}}
        </div>
        <div class="banner-site-mob">
            {{league()->ads('300x250')}}
        </div>
    </div>

    <div class="row">
        <div class="col-xl-9 col-lg-8">
            <div class="last-news">
                @foreach ($rows as $category)
                    @include('home.category',[
                    'category' => $category,
                    'big_class' => 'col-xl-6',
                    'additional_class' => 'col-xl-6'
                ])
                @endforeach
                <div class="row">
                    @foreach ($rows as $category)
                        @include('home.category',[
                        'category' => $category,
                        'wrapper_class' => 'col-12 col-xl-6',
                        'additional_class' => 'mt-xl-4 mt-0'
                    ])
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4">
            <div class="banner-site-pc">
                {{league()->ads()}}
            </div>
            @php dynamic_sidebar('home-right-sidebar') @endphp
        </div>
    </div>
    @include('includes.banner')
@endsection