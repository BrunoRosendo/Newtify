@extends('layouts.app')

@php
$tagline = 'Que rego amiguinho'
@endphp

{{-- ------------------------------------------------------------------------------------ --}}
@section('create-article')

<div id="homepage" class="d-flex justify-content-center py-3">
    <div class="d-flex flex-grow-1 justify-content-center createArticleContainer">
        <div id="createArticle" class="position-relative d-flex flex-column align-items-center" >
            <h1> Create Your Own Article </h1>
            <h3> {{ $tagline }} </h3>
            <div class="addIcon"> 
                <i class="fas fa-plus-circle fa-4x" onclick="console.log('Clicked')"></i>
            </div>   
        </div>
    </div>
</div>

@endsection


{{-- ------------------------------------------------------------------------------------ --}}

@section('articles')
    <section id="articles" class="container">
        @include('partials.content.articles', ['articles' => $articles])
    </section>
@endsection

{{-- ------------------------------------------------------------------------------------ --}}

@section('load-more')
<div id="load-more">

    <button onclick="loadMoreHome()">Load more</button>

</div>
@endsection


@section('articles')
    @include('partials.content.articles', ['articles' => $articles])
@endsection

{{-- ------------------------------------------------------------------------------------ --}}

@section('content')

    @yield('create-article')
    @yield('articles')

    @if ($canLoadMore)
        @yield('load-more')
    @endif    

@endsection
