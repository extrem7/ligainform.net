@extends('layouts.base')
@section('content')
    <div class="row">
        <div class="col-xl-9 d-pc-100">
            <div class="page-title text-center line">@title</div>
            <div class="text-center dynamic-content info-page">@content</div>
            @include('includes.banner')
        </div>
        <div class="col-xl-3 d-none d-xl-block">
            @include('articles.includes.last-items')
        </div>
    </div>
@endsection