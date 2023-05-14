@extends('layouts.app')

@section('content')
<div class="container p-0">
    <div class="row w-100 m-0">
        <div class="col-7 mt-5" id="post">
            
            @if($all_posts->isNotEmpty())
                @foreach ($all_posts as $post)
                    <div class="card mb-4 bg-dark text-white border">
                        @include('users.posts.contents.header')
                        @include('users.posts.contents.body')
                    </div>
                @endforeach
            @endif
        </div>

        <div class="col mt-5 d-none d-lg-block" id="suggestion">
            <div class="search-box" id="search">
                <form action="{{ route('search') }}" method="get">
                    @csrf
                    <input type="text" name="search" class="form-element" placeholder="Search" required>
                    <button class="btn btn-sm"><i class="fas fa-search" id="search_icon"></i></button>
                </form>
            </div>
            {{-- @if( Auth::user()->checkUserHasFollowers(Auth::user()->id) )
                <div class="card-header mt-5">
                    <i class="far fa-user text-info" id="sug_icon"></i>
                    <p class="d-inline"> &nbsp;知り合いかも?</p>
                </div>
                <div class="card-body mt-4 ">
                    @foreach($users as $user)
                        @if ($user->isFollowing() && !$user->isFollowed())
                        <div class="row mt-3">
                            <div class="col-2">
                                @if($user->avatar)
                                    <img src="data:image/png;base64,{{ $user->avatar }}" alt="{{    $user->avatar }}" class="rounded-circle nav-avatar" id="sug_user_img">
                                @else
                                    <i class="fas fa-user-circle" id="sug_icon"></i>
                                @endif
                            </div>
                            <div class="col fw-bold mt-1">
                                {{ $user->name }}
                            </div>
                            <div class="col">
                                <form action="{{ route('follow.store', $user->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-none text-primary mb-2 ">
                                        Follow
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            @endif --}}
        </div>
</div>
@endsection
