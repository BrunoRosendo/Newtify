@extends('layouts.app')

<script type="text/javascript" src="{{ asset('js/feedbackContent.js') }}"></script>

@section('article')
    <div class="article-container h-100 container-fluid bg-dark rounded mt-3 mb-5">

        <div class="d-flex flex-row my-2 h-100" style="min-height: 65vh">
            
            <div class="articleInfoContainer d-flex flex-column p-3 mb-0 text-white" >

                <div class="flex-row h1" id="articleTitle">
                    {{ $article['title'] }}
                </div>

                <div class="d-flex justify-content-between align-items-center flex-row">
                    @php
                        $article_published_at = date('F j, Y', /*, g:i a',*/ strtotime($article['published_at']));
                    @endphp
                    <i id="publishedAt">{{ $article_published_at }}</i>

                    @if ($isAuthor || $isAdmin)
                        <div id="articleButtons">
                            @if ($isAuthor)
                                <a href="{{ route('editArticle', ['id' => $article['id']])}}">
                                    <i class="fas fa-edit article-button me-4"></i>
                                </a>
                            @endif

                            <form name="deleteArticleForm" id="deleteArticleForm" method="POST"
                                action="{{ route('article', ['id' => $article['id']]) }}">

                                @csrf
                                @method('DELETE')

                                @if ($errors->has('article'))
                                    <div class="alert alert-danger mt-2 mb-0 p-0 w-50 text-center" role="alert">
                                        <p class="mb-0">{{ $errors->first('article') }}</p>
                                    </div>
                                @endif
                                @if ($errors->has('content'))
                                    <div class="alert alert-danger mt-2 mb-0 p-0 w-50 text-center" role="alert">
                                        <p class="mb-0">{{ $errors->first('content') }}</p>
                                    </div>
                                @endif
                                @if ($errors->has('user'))
                                    <div class="alert alert-danger mt-2 mb-0 p-0 w-50 text-center" role="alert">
                                        <p class="mb-0">{{ $errors->first('user') }}</p>
                                    </div>
                                @endif

                            </form>
                            <button onclick="document.deleteArticleForm.submit();" class="btn btn-transparent">
                                <i class="fas fa-trash article-button text-danger"></i>
                            </button>
                        </div>
                    @endif
                </div>

                <p class="flex-row mt-3 mb-1 h-25">

                    @foreach ($tags as $tag)
                        @include('partials.tag', ['tag' => $tag ])
                    @endforeach

                    @if ( $liked )
                        <i class="fas fa-thumbs-up ps-5 purpleLink feedbackIcon" 
                            id="articleLikes" 
                            onclick="removeFeedback(this, {{ $article['id'] }}, true)"
                            > 
                            <span class="ms-1">{{ $article['likes'] }}</span>
                        </i>
                    @else 
                        <i class="fas fa-thumbs-up ps-5 feedbackIcon" id="articleLikes" onclick="giveFeedback(this, {{ $article['id'] }}, true)"> 
                            <span class="ms-1">{{ $article['likes'] }}</span>
                        </i>
                    @endif

                    @if ($disliked)
                        <i class="fas fa-thumbs-down ps-3 feedbackIcon purpleLink" id="articleDislikes" onclick="removeFeedback(this, {{ $article['id'] }}, false)"> 
                            <span class="ms-1">{{ $article['dislikes'] }}</span>
                        </i>
                    @else
                        <i class="fas fa-thumbs-down ps-3 feedbackIcon" id="articleDislikes" onclick="giveFeedback(this, {{ $article['id'] }}, false)"> 
                            <span class="ms-1">{{ $article['dislikes'] }}<span>
                        </i>
                    @endif 
                    
                    <button onclick="showSocials()" class="btn ms-4">
                        <i class="fas fa-share-alt fa-2x"></i>
                    </button>
                </p>

                @if (isset($article['thumbnail']))
                    <div class="flex-row h-50 mb-5 text-center">
                        <img class="h-100 w-50" src="{{ asset('storage/thumbnails/' . $article['thumbnail']) }}"
                            onerror="this.src='{{ $articleImgPHolder }}'">
                    </div>
                @endif

                <div id="articleBody" class="flex-row h-75">
                    {{ $article['body'] }}
                </div>

            </div>

            <div class="author-container flex-col me-4 mt-4 p-3 text-black rounded">
                @include('partials.authorInfo', [
                    'author' => $author,
                    'isOwner' => $isAuthor
                ])
            </div>

        </div>

        <div class="d-flex flex-column" id="comments-section">

            @if (!$comments->isEmpty() || Auth::check())
                <div class="flex-row my-3 p-0">
                    <h3 class="m-0">Comments</h3>
                </div>
            @endif

            <div class="h-50">
                @if (Auth::check())
                    <div class="d-flex flex-row mx-0 my-3 p-0 w-75">
                        <div class="flex-column h-100 commentHeader mx-5 my-0 p-0">
                            <img src="{{ isset(Auth::user()->avatar) ? asset('storage/avatars/' . Auth::user()->avatar) : $userImgPHolder }}"
                                onerror="this.src='{{ $userImgPHolder }}'">
                            <p>You</p>
                        </div>
                        <div class="flex-column m-0 p-0 w-100">
                            <form action="/make_comment.php" method="POST" id="comment_form" class="m-0">
                                <textarea class="flex-column m-0 p-2" placeholder="Type here"></textarea>
                                <button type="button" class="btn btn-primary px-4">
                                    Comment
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

                <div id="comments">
                    @include('partials.content.comments', ['comments' => $comments])
                </div>

                @if ($canLoadMore)
                <div id="load-more" class="w-75 my-3">
                    <button onclick="loadMoreComments({{ $article['id'] }})">Load more</button>
                </div>
                @endif

            </div>

        </div>
    </div>
@endsection

@section('popup')
    <section id="socialsPopup" class="d-block d-none fullPopup">
        <div id="backdrop" onclick="hideSocials()"></div>
        <div id="socialsPopupContainer" class="d-flex flex-column justify-content-center align-items-center popupContainer">
            <div id="socialsPopupInside" class="d-flex flex-column align-items-center justify-content-evenly popupInsideContainer">
                <h3>Share in your Social Media!</h3>
                <div class="row">
                    <div class="col-3 text-center">
                        <a id="fbIcon" target="_blank" class="btn btn-outline-purple btn-lg fa fa-facebook fa-2x"></a>
                    </div>
                    <div class="col-3 text-center">
                        <a id="twitterIcon" target="_blank" class="btn btn-outline-purple btn-lg fa fa-twitter fa-2x"></a>
                    </div>
                    <div class="col-3 text-center">
                        <a id="linkedInIcon" target="_blank" class="btn btn-outline-purple btn-lg fa fa-linkedin fa-2x"></a>
                    </div>
                    <div class="col-3 text-center">
                        <a id="redditIcon" target="_blank" class="btn btn-outline-purple btn-lg fa fa-reddit fa-2x"></a>
                    </div>
                </div>
                <button class="btn p-0 m-0 transparentButton" id="socialsCloseBtn" onclick="hideSocials()">
                    <i class="fa fa-times fa-3x text-purple" id="closeIcon"></i>
                </button>
            </div>
        </div>
    </section>
@endsection

@section('content')
    @yield('article')
    @yield('popup')
@endsection
