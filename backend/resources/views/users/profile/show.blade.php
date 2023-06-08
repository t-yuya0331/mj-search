@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container w-100" id="profile_container">
    <div class="row">
        <div class="col text-center">
            @if($user->avatar)
                <img src="data:image/png;base64,{{ Auth::user()->avatar }}" alt="{{ Auth::user()->avatar }} " class="rounded-circle nav-avatar" id="profile_user_avatar">
            @else
                <i class="fa-solid fa-circle-user text-dark" id="user_icon"></i>
            @endif
            <h3 class="d-inline ms-3">
                {{ $user->name }}さんのプロフィール
            </h3>

            @if (Auth::user()->id == $user->id)
                <a href="{{ route('profile.edit', Auth::user()->id) }}" >Edit Profile</a>
            @endif
        </div>
    </div>

    <div class="justify-content-center">
        <p>投稿一覧</p>
        @foreach ($posts as $post)
        <div class="card-header p-0 ms-2 mt-2" id="post_header">
            <div class="row w-100">
                <div class="col-auto pe-0">
                    @if($post->user->avatar)
                        <img src="data:image/png;base64,{{ $post->user->avatar }}" alt="{{  $post->user->avatar }}" class="rounded-circle nav-avatar" id="user_img">
                    @else
                        <i class="fas fa-user-circle user-icon" id="user_icon"></i>
                    @endif
                </div>
                <div class="col-auto text-start ps-2" id="post_detail">
                    <p class="text-decoration-none text-white">
                        {{ $post->user->name }}
                    </p>
                </div>
                <div class="col" id="post_detail">
                    <p class="text-info mt-1 ps-3">{{ $post->created_at->diffForHumans() }}</p>
                </div>
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
        </div>
        @endforeach
    </div>

</div>

@endsection
