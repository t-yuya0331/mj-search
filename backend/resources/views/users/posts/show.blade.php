@extends('layouts.app')

@section('title','Show Post')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 p-0 bg-dark" id="show_post">
            <div class="card-header ms-2 mt-2 bg-dark">
                @if($post->user->avatar)
                    <img src="data:image/png;base64,{{ $post->user->avatar }}" alt="{{ $post->user->avatar }}" class="rounded-circle nav-avatar" id="user_img">
                @else
                    <i class="fas fa-user-circle user-icon" id="user_icon"></i>
                @endif
                    &nbsp; <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-white" id="user_name">
                        {{ $post->user->name }}
                    </a>
                    <p class="d-inline text-info" id="time">{{ $post->created_at->diffForHumans() }}</p>

                <div class="float-end text-center">
                    <div class="dropdown">
                        <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-ellipsis text-secondary"></i>
                        </button>
                        <div class="dropdown-menu">
                            @if(Auth::user()->id !== $post->user->id)
                                @if($post->user->isFollowed())
                                    <form action="{{ route('follow.destroy', $post->user->id) }}"     method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm shadow-none text-danger  text-center"> <i class="fas fa-plus"></i> Unfollow </button>
                                    </form>
                                @endif
                            @else
                            <button class="btn btn-sm shadow-none text-warning text-center"> <i class="fas fa-edit"></i> Edit </button>
                            <button class="btn btn-sm shadow-none text-danger text-center"> <i class="fas fa-trash"></i> Dlete</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="row">
                    <div class="col-auto">
                        <p class="mt-2 w-75 text-white" id="post_description">
                            {!! nl2br(e($post->description )) !!}
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col ">
                    @if($post->user_id !== Auth::user()->id)
                        @if ($post->isLiked())
                            <form action="{{ route('nice.destroy',$post->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm shadow-none ps-0">
                                    <i class="fa-dark fa-heart " style="font-size: 1.5rem"></i>
                                </button>
                                &nbsp;{{$post->nices->count()}}
                            </form>
                        @else
                            <form action="{{ route('nice.store',$post->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-sm shadow-none ps-0">
                                    <i class="fa-solid fa-heart" id="heart"></i>
                                </button>
                                &nbsp;{{$post->nices->count()}}
                            </form>
                        @endif
                    @endif
                    </div>
                </div>

                @if($post->image)
                    <a href="{{ route('post.show', $post->id) }}">
                        <img src="data:image/png;base64,{{ $post->image }}" alt="{{ $post->image }}"   class="img-fluid border" id="show_post_img">
                    </a>
                @endif
            </div>

            <div class="card-footer bg-light">
                <div class="row">
                    @foreach ($post->comments() as $comment)
                        <div class="row mb-3">
                            <div class="col">
                                @if ($comment->user->avatar)
                                    <img src="#" alt=""> &nbsp;&nbsp;
                                @else
                                    <i class="fas fa-circle-user"></i>&nbsp;&nbsp;
                                @endif
                                    <a href="" class="text-decoration-none text-dark">
                                        {{ $comment->user->name }}
                                    </a>
                                    &nbsp;&nbsp;
                                    <span>
                                        {{ $comment->body }}
                                    </span>
                                    @if ($comment->user->id == Auth::user()->id)

                                    <form action="{{ route('comment.destroy', $comment->id) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn text-danger shadow-none btn-sm">Delete</button>
                                    </form>
                                    @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
