<div class="card user-card flex-row flex-wrap mb-3">
    <div class="user-card-avatar px-2 py-2">
        <a href="/user/{{ $user['id'] }}"> <img src= {{
            isset($user['avatar']) ?
            $user['avatar']
            :
            $userImgPHolder
        }} style="border-radius: 50%;"> </a>
    </div>

    <div class="card-block user-card-body d-flex flex-column px-4 py-4">
        <h4 class="card-title mb-0">
            <a href="/user/{{ $user['id'] }}">{{ $user['name'] }}</a>
        </h4>

        <p class="user-card-location">
            @if (isset($user['city']))
                {{ $user['city'] }}, {{ $user['country']->name }}
            @else
                {{ $user['country']->name }}
            @endif
        </p>

        <p class="user-card-description">{{ mb_strimwidth($user['description'], 0, 300, "...") }} </p>
    </div>

    <div class="card-block user-card-right d-flex flex-column align-items-center justify-content-start py-4">
        @if ($user['isAdmin'])
            <span class="badge rounded-pill bg-custom mb-4"> Admin </span>
        @endif

        <p class="user-card-description mt-4 mb-4">Reputation: {{ $user['reputation'] }}</p>

        @foreach ($user['topAreasExpertise'] as $area)
            <span class="badge bg-secondary mb-2">
                {{ $area['tag_name'] }}
            </span>
        @endforeach
    </div>
    
</div>

