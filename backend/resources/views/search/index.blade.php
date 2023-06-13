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
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            @if($search_posts->isNotEmpty())
                <div class="card p-0">
                    <div class="" id="search_post">
                        @foreach($search_posts as $post)
                            @if($post->user_id != Auth::user()->id && $post->role_id != 2 && $post->status != 2)
                                <div class="card mb-4 bg-dark text-white border">
                                    <div class="card-header p-0 ms-2 mt-2" id="post_header">
                                        <div class="row w-100">
                                            <div class="col-auto pe-0">
                                                @if($post->user->avatar)
                                                    <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none  text-white">
                                                        <img src="data:image/png;base64,{{ $post->user->avatar }}" alt="{{  $post->user->avatar }}" class="rounded-circle nav-avatar"   id="user_img">
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
                                    </div>
                                    <div class="card-body p-0">
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
                                                <p>ルール</p>
                                                @foreach ($post->categoryPost as $category_post)
                                                    <span class="badge bg-secondary bg-opacity-50">
                                                        {{ $category_post->category->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-auto">
                                                <p class="mt-2 w-75" id="post_description">
                                                    {!! nl2br(e($post->description )) !!}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @if($post->user->id !== Auth::user()->id)
                                                <a href="{{ route('chat.showChat', $post->user->id) }}" class="btn btn-primary w-75 mx-auto">
                                                    <p>投稿者にチャットで確認する</p>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
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


