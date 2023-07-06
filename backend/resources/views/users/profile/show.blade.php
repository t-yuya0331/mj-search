@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container" id="profile_container">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Profile</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="posts-tab" data-bs-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="false">過去の投稿</a>
        </li>
    </ul>
    {{-- profile area --}}
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            @if($user->id == Auth::user()->id)
                <form action="{{ route('profile.update', $user->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                    <div class="profile-area">
                        <div class="mb-3">
                            <label for="avatar" class="form-label">Profile Picture</label>
                            <div class="profile-picture">
                                @if($user->avatar)
                                    <img src="data:image/png;base64,{{ $user->avatar }}" alt="{{ $user->avatar }}" class="rounded-circle nav-avatar">
                                @else
                                    <i class="fa-solid fa-user-circle "></i>
                                @endif
                            </div>
                            <input type="file" name="avatar" id="avatar" class="form-control" value="{{         $user->avatar }}">
                            @error('avatar')
                                <p class="text-danger small">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{     $user->name }}">
                            @error('name')
                                <p class="text-danger small">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{  $user->email }}">
                            @error('email')
                                <p class="text-danger small">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="introduction" class="form-label">Introduction</label>
                            <textarea name="introduction" id="introduction" cols="30" rows="5"  class="form-control">{{ $user->introduction }}</textarea>
                            @error('introduction')
                                <p class="text-danger small">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn" id="profile-button">保存する</button>
                        </div>
                    </div>
                </form>
            @else
                <div class="user-info mt-3">
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Profile Picture</label>
                        <div class="profile-picture">
                            @if($user->avatar)
                                <img src="data:image/png;base64,{{ $user->avatar }}" alt="{{    $user->avatar }}" class="rounded-circle nav-avatar">
                            @else
                                <i class="fa-solid fa-user-circle "></i>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <div class="form-value">{{ $user->name }}</div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="form-value">{{ $user->email }}</div>
                    </div>
                    <div class="mb-3">
                        <label for="introduction" class="form-label">Introduction</label>
                        <div class="form-value" id="introduction">{{ $user->introduction }}</div>
                    </div>
                </div>
            @endif
        </div>

        {{-- posts area --}}
        <div class="tab-pane fade" id="posts" role="tabpanel" aria-labelledby="posts-tab">
            @if($posts->isNotEmpty())
                @foreach ($posts as $post)
                <div class="card ps-2 mt-3 mx-auto" id="posts-card">
                    <div class="card-header p-0">
                        <div class="row w-100">
                            <div class="col-auto pe-0">
                                @if($post->user->avatar)
                                    <img src="data:image/png;base64,{{ $post->user->avatar }}" alt="{{          $post->user->avatar }}" class="rounded-circle nav-avatar" id="user_img">
                                @else
                                    <i class="fas fa-user-circle user-icon" id="user_icon"></i>
                                @endif
                            </div>
                            <div class="col-auto text-start ps-2" id="user-name">
                                <p class="text-decoration-none my-auto">
                                    {{ $post->user->name }}
                                </p>
                            </div>
                            <div class="col" id="posts-detail">
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
                                <p class="mt-2 w-75" id="posts-description">
                                    {!! nl2br(e($post->description )) !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="">
                    <p>過去の投稿はありません</p>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
