@extends('layouts.app')

@section('content')
<div class="container p-0">
    <div class="row justify-content-center mx-auto" id="search_area">
        <div class="card p-0 bg-transparent" id="search_card">
            <div class="card-header pb-0 pt-2 ">
                <div class="search-box w-75 mx-auto" id="search">
                    <form action="{{ route('search') }}" method="get">
                        @csrf
                        <input type="text" name="search" class="form-element" value="{{ $keyword }}" required style="border-radius: 20px;">
                        <button class="btn btn-sm"><i class="fas fa-search" id="searched_icon"></i></button>
                    </form>
                </div>
            </div>
            @if($search_users->isNotEmpty())
                <div class="card-body">
                    <div class="" id="search_user">
                        @foreach($search_users as $user)
                            @if($user->id !== Auth::user()->id)
                                <div class="row">
                                    <div class="col-auto">
                                        @if($user->avatar)
                                        <a href="{{ route('profile.show', $user->id) }}">
                                            <img src="data:image/png;base64,{{ $user->avatar }}" alt="{{  $user->avatar }}" class="rounded-circle nav-avatar" id="search_user_avatar">
                                        </a>
                                        @else
                                            <i class="fas fa-user-circle" id="search_user_icon"></i>
                                        @endif
                                    </div>
                                    <div class="col-auto fw-bold mt-1">
                                        {{ $user->name }}
                                    </div>
                                    <div class="col">
                                        <form action="{{ route('follow.store', $user->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn    btn-none   text-primary ">
                                                Follow
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            @if($search_posts->isNotEmpty())
                <div class="card-body p-0">
                    <div class="" id="search_post">
                        @foreach($search_posts as $post)
                            @if($post->user_id != Auth::user()->id)
                            <div class="card mb-4 bg-dark text-white border">
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
                                        <div class="col p-0">
                                            <div class="float-end text-center">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm shadow-none"  data-bs-toggle="dropdown">
                                                        <i class="fa-solid fa-ellipsis text-secondary"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        @if(Auth::user()->id !== $post->user->id)
                                                            @if($post->user->isFollowed())
                                                                <form action="{{ route('follow.destroy', $post->user->id) }}"     method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="btn btn-sm shadow-none text-danger  text-center">
                                                                        <i class="fas fa-plus" id="follow"> Unfollow</i>
                                                                    </button>
                                                                </form>
                                                            @else
                                                                <form action="{{ route('follow.store', $post->user->id) }}" method="post">
                                                                    @csrf
                                                                    <button class="btn btn-sm shadow-none text-primary  text-center">
                                                                        <i class="fas fa-plus" id="follow"> Follow</i>
                                                                    </button>
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
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="row w-100">
                                        <div class="col-auto">
                                            <p class="mt-2 w-75" id="search_post_description">
                                                {!! nl2br(e($post->description )) !!}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="card-footer" id="search_post_footer">
                                    <hr class="m-0">
                                    <div class="row">
                                        @if ($post->isLiked() )
                                            <div class="col-1 me-0">
                                                <form action="{{ route('nice.destroy', $post->id) }}"method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm shadow-none p-0" type="submit" id="search_heart">
                                                        <i class="fa-solid  text-danger  fa-heart"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <div class="col-1 me-0">
                                                <form action="{{ route('nice.store', $post->id) }}"method="post">
                                                    @csrf
                                                    <button class="btn btn-sm shadow-none p-0" type="submit" id="search_heart">
                                                        <i class="fa-regular    fa-heart"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                        <div class="col-1">
                                            <p class="ms-4 mt-2 text-secondary">{{$post->nices->count()}}</p>
                                        </div>
                                        <div class="col-1 pe-0 text-center">
                                            <a href="{{ route('profile.show', $post->user->id) }}">
                                                <i class="fa-regular fa-comment mt-2" id="search_comment_icon"></i>
                                            </a>
                                        </div>
                                        <div class="col-1 ps-0 mt-2">
                                            <p class="text-secondary" id="search_comment_num">&nbsp;{{ $post->comments->count() }}<p>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection


