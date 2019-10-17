@extends('layouts.base')
@section('content')
    <div class="row">
        <div class="col-xl-9 d-pc-100">
            <div class="page-title text-center">@title</div>
            <div class="correspondent-profile">{{the_post_thumbnail('full', ['alt' => get_the_title()])}}</div>
            <div class="correspondent-info">
                <div class="correspondent-name text-center mb-4">{{get_field('name')}}</div>
                <div class="correspondent-text text-center">
                    <div class="mb-2">Должность: {{get_field('role')}}</div>
                    <div class="mb-2">Статус: <span class="active">{{get_field('status')}}</span></div>
                    <div class="mb-2">Удостоверение действительно до: {{get_field('expiration')}}</div>
                </div>
            </div>
            @include('includes.banner')
        </div>
        <div class="d-pc-none col-xl-3">
            @include('articles.includes.last-items')
        </div>
    </div>
@endsection