<? /* Template Name: RSS-ленты */ ?>
@extends('layouts.base')
@section('content')
    <div class="row">
        <div class="col-xl-9 ">
            <div class="page-title text-center">@title</div>
            <div class="rss-text text-center">@content</div>
            @include('includes.feeds')
            @include('includes.banner')
        </div>
        <div class=" col-xl-3">
            @include('articles.includes.last-items')
        </div>
    </div>
@endsection