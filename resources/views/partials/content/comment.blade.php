<div class="d-flex flex-row mx-0 my-3 p-0 {{ $isReply ? 'w-100' : 'w-75' }}"> 
    <div class="flex-column h-100 commentHeader mx-5 my-0 p-0">
        <img src="{{
            (isset($comment['author']) && isset($comment['author']['avatar'])) ?
            asset('storage/avatars/'.$comment['author']['avatar']) : $userImgPHolder 
        }}" onerror="this.src='{{ $userImgPHolder }}'" />

        @if (isset($comment['author']))
            {{ $comment['author']['name'] }}
        @else
            <i>Anonymous</i>
        @endif
    </div>

    <div class="flex-column m-0 p-0 w-100">
        <div class="commentTextContainer border border-light flex-column p-3 mb-3">{{ $comment['body'] }}</div>
        
        <i class="fa fa-thumbs-up "> {{ $comment['likes'] }}</i>
        <i class="fa fa-thumbs-down ps-3 pe-3"> {{ $comment['dislikes'] }}</i>

        @if (Auth::check() && !$isReply)
            <span onclick="openReplyBox(this.parentNode.parentNode, {{ $comment['article_id'] }}, {{ $comment['id'] }})"
                class="px-3 hover-pointer">Reply</span>
        @endif

        <span class="px-3">{{ $comment['published_at'] }}</span>
    </div>

</div>
