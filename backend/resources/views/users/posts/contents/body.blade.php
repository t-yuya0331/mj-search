<div class="card-body p-0 ms-2">
    <div class="row">
        <div class="col-auto">
            <p>募集日:&nbsp;{{ $post->date }}</p>
        </div>
        <div class="col-auto">
            <p>時間:&nbsp;{{ $post->time }}</p>
        </div>
        <div class="col-auto">
            <p>場所:&nbsp;{{ $post->location }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-auto">
            <p>募集人数:&nbsp;{{ $post->number }}</p>
        </div>
        <div class="col-auto">
            @if ($post->target == App\Constants\TargetType::Beginner)
                <p>募集対象:&nbsp;初級者</p>
            @elseif ($post->target == App\Constants\TargetType::Intermediate)
                <p>募集対象:&nbsp;中級者</p>
            @elseif ($post->target == App\Constants\TargetType::Advanced)
                <p>募集対象:&nbsp;上級者</p>
            @elseif ($post->target == App\Constants\TargetType::Anyone)
                <p>募集対象:&nbsp;誰でも歓迎</p>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-auto">
            <p class="mb-0">ルール</p>
            @foreach ($post->categoryPost as $category_post)
                <span class="badge bg-secondary bg-opacity-50">
                    {{ $category_post->category->name }}
                </span>
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p class="mt-2 w-75" id="post_description">
                {!! nl2br(e($post->description )) !!}
            </p>
        </div>
    </div>
    <div class="row">
        @if($post->user->id !== Auth::user()->id)
            <a href="{{ route('chat.showChat', $post->user->id) }}" class="btn mx-auto mb-2" id="chat-button">
                <p class="m-0">Chat</p>
            </a>
        @endif
    </div>
</div>
