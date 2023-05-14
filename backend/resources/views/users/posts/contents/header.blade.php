<div class="card-header p-0 ms-2 mt-2" id="post_header">
    <div class="row w-100">
        <div class="col-auto pe-0">
            @if($post->user->avatar)
                <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none  text-white">
                    <img src="data:image/png;base64,{{ $post->user->avatar }}" alt="{{  $post->user->avatar }}" class="rounded-circle nav-avatar" id="user_img">
                </a>
            @else
                <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none  text-white">
                    <i class="fas fa-user-circle user-icon" id="user_icon"></i>
                </a>
            @endif
        </div>
        <div class="col-auto text-start ps-2" id="post_detail">
            <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-white">
                {{ $post->user->name }}
            </a>
        </div>
        <div class="col" id="post_detail">
            <p class="text-info mt-1 ps-3">{{ $post->created_at->diffForHumans() }}</p>
        </div>
        @if(Auth::user()->id == $post->user->id && $post->role_id !== 2)
            <div class="col p-0">
                <div class="float-end text-center">
                    <div class="dropdown">
                        <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-ellipsis text-secondary"></i>
                        </button>
                        <div class="dropdown-menu">
                            <form action="{{ route('post.changeStatus', $post->id) }}"      method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="dropdown-item">募集を終了する      </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
