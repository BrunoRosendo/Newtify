@extends('layouts.app')

@php
$guest = !Auth::check();
@endphp

<script type="text/javascript" src={{ asset('js/user.js') }}></script>

{{-- ------------------------------------------------------------------------------------ --}}
@section('userInfo')
    <section id="userInfo">
        <div class="container-fluid py-3">
            <div class="row w-100 mt-4 mt-md-5" id="userGraphics">
                <div class="col-5 col-md-6 d-flex justify-content-center align-items-center h-100">
                    <img src="{{ isset($user['avatar']) ? asset('storage/avatars/' . $user['avatar']) : $userImgPHolder }}"
                        id="avatarImg" onerror="this.src='{{ $userImgPHolder }}'" />

                </div>
                <div class="col-7 col-md-6 d-flex flex-column align-items-center h-100">
                    <div id="areasOfExpertiseContainer" class="h-100">
                        @include('partials.user.areasOfExpertiseGraph', ['topAreasExpertise' => $topAreasExpertise ])
                    </div>
                </div>
            </div>
            <div class="row w-100 my-4 mt-md-5">
                <div class="col-5 col-md-6 d-flex justify-content-center align-items-center position-relative">
                    <h2 class="text-center my-0 py-0">{{ $user['name'] }}</h2>
                    @if ($user['isAdmin'])
                        <span id="adminBadge" class="badge rounded-pill ms-3 bg-custom">Admin</span>
                    @endif
                </div>
                <div class="col-7 col-md-6 d-flex justify-content-center align-items-center">
                    @if ($isOwner)
                        <button type="button" class="btn transparentButton my-0 py-0 me-5 rounded-circle">
                            <a class="fa fa-pencil darkPurpleLink icon-3x" href="/user/{{ $user['id'] }}/edit"></a>
                        </button>
                    @else
                        @if (!$guest)
                            <i class="fa fa-comment-dots me-3 text-purple-dark icon-2x" onclick="console.log('clicked')"></i>
                            @if ($follows)
                                <button type="button" class="btn btn-secondary px-md-5 my-0 py-0 mx-3" id="followBtn"
                                    onclick="unfollowUser({{ $user['id'] }})">Unfollow</button>
                            @else
                                <button type="button" class="btn btn-primary px-md-5 my-0 py-0 mx-3" id="followBtn"
                                    onclick="followUser({{ $user['id'] }})">Follow</button>
                            @endif
                        @endif
                    @endif
                    <i class="fa fa-users mx-3 text-primary icon-2x"></i>
                    <p class="h5 py-0 my-0" id="followersCount">{{ $followerCount }}</p>
                </div>
            </div>
            <div class="row w-100 my-2">
                <div class="col-12 col-md-6 d-flex flex-column align-items-center">
                    <div class="d-flex align-items-center my-2 my-md-0 mb-3">
                        <i class="fa fa-birthday-cake me-3 fa-1x" onclick="console.log('cliked')"></i>
                        <h5 class="mb-0">{{ $birthDate . ' (' . $age . ')' }}</h5>
                    </div>
                    <div class="d-flex align-items-center my-2 my-md-0 mb-3">
                        &#{{ $user['country']['flag'][0] }}&#{{ $user['country']['flag'][1] }}
                        <h5 class="mb-0 ms-3">
                            {{ (is_null($user['city']) ? '' : $user['city'] . ', ') . $user['country']['name'] }}</h5>
                    </div>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-center align-items-center mt-2 mt-md-0">
                    @include('partials.user.reputationBar', ['user' => $user, 'isOwner' => $isOwner])
                </div>
            </div>
        </div>
    </section>
@endsection

{{-- ------------------------------------------------------------------------------------ --}}

@section('articles')
    <section class="container-fluid w-100 d-flex flex-column align-items-center my-2 ">
        <div class="position-relative w-100 d-flex justify-content-center align-items-center mb-2 mb-md-4" id="userArticles">
            <h2 class="border-bottom border-2 border-light text-center pb-2" id="articlesTitle">Articles</h2>
        </div>
        <div id="articles">
            @include('partials.content.articles', ['articles' => $articles])
        </div>
    </section>
@endsection

{{-- ------------------------------------------------------------------------------------ --}}

@section('load-more')
    <div id="load-more">

        <button onclick="loadMoreUser({{ Auth::id() }})">Load more</button>

    </div>
@endsection

{{-- ------------------------------------------------------------------------------------ --}}

@section('report')
    @include('partials.user.reportPopup', ['id' => $user['id']])
@endsection

{{-- ------------------------------------------------------------------------------------ --}}

@section('content')
    <div id="userProfileContainer" class="d-flex flex-column">
        @yield('userInfo')
        @yield('articles')
        @yield('report')

        @if ($canLoadMore)
            @yield('load-more')
        @endif
    </div>
@endsection
