<div class="card-footer">
    <hr>
    <p class="comment">Comment</p>
    @if ($post->comments )
        @foreach ($post->comments->take(3) as $comment)
            <div class="row mb-2">
                <div class="col-9 border bg-white pt-1">
                    <p class="fw-normal">{{ $comment->user->name }}:
                        &nbsp; &nbsp; <span class="fw-bold">{{ $comment->body }}</span>
                    </p>
                </div>


                @if ($comment->user->id == Auth::user()->id)
                <div class="col">
                    <form action="{{ route('comment.destroy', $comment->id) }}" method="post" class="float-end d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn text-danger shadow-none btn-sm">Delete</button>
                    </form>
                </div>
                @endif
            </div>
        @endforeach
        @if ($post->comments->count() > 3)
            <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none">View all comments({{$post->comments->count()}})</a>
        @endif

    @endif

    <div class="row">
        <div class="col">
            <form action="{{ route('comment.store', $post->id) }}" method="post">
                @csrf
                <div class="input-group">
                    <input type="text" name="body" id="body" class="form-control">
                    <div class="small">
                        @error('body')
                        {{ $message }}
                        @enderror
                    </div>
                    <button class="btn btn-secondary" type="submit"> <i class="fas fa-check "></i> </button>
                </div>
            </form>
        </div>
    </div>
</div>
