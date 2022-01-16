<div class="card flex-row flex-wrap bg-secondary">
    <div class="card-header border-0 h-100 bg-transparent">
        <img class="h-100" src="{{
            isset($article['thumbnail']) ?
            asset('storage/thumbnails/'.$article['thumbnail'])
            :
            $articleImgPHolder
        }}" onerror="this.src='{{ $articleImgPHolder }}'">
    </div>

    <a href="/article/{{ $article['id'] }}" class="h-100">
        <div class="card-block d-flex flex-column px-2 h-100">
            <h4 class="card-title">
                {{ $article['title'] }}
            </h4>

            <span class="card-text"> 
                <i class="far fa-clock pe-2"> 
                    @php
                        $time = date('F j, Y', /*, g:i a',*/ strtotime( $article['published_at'] ) )
                    @endphp
                    {{ $time }}
                </i>

                <i class="fa fa-thumbs-up ms-3 me-2"> {{ $article['likes'] }}</i>
                <i class="fa fa-thumbs-down"> {{ $article['dislikes'] }}</i>
            </span>

            <p class="card-text text-light-white">{{ mb_strimwidth($article['body'], 0, 300, "...") }} </p>
        </div>
    </a>
    
</div>
