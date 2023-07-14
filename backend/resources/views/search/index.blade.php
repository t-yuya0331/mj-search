@extends('layouts.app')

@section('content')
<div class="search-contianer">
    <div class="row justify-content-center" >
        <div class="col mt-2" id="search_area">
                <div class="card-header mt-3 mb-5">
                    <div class="search-box w-50 mx-auto my-auto">
                        <form action="{{ route('search') }}" method="get">
                            @csrf
                            <div class="row search-input-area mx-auto">
                                <div class="">
                                    <button class="btn btn-sm" id="searched-icon"><i class="fas fa-search"></i></button>
                                    <input type="text" name="search" class="form-element" value="{{ $keyword }}" required style="border-radius: 20px;">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- searched user area --}}
                @if($search_users->isNotEmpty())
                <div class="card mb-3" id="chat-list">
                    <ul class="list-group list-group-flush">
                        @foreach($search_users as $user)
                            @if($user->id !== Auth::user()->id)
                                <li class="list-group-item mt-1 mb-2" style="padding:0px;">
                                    @if($user->avatar)
                                        <img src="data:image/png;base64,{{ $user->avatar }}" alt=" {{ $user->avatar }}" class="rounded-circle nav-avatar"   id="chat_list_user_avatar">
                                    @else
                                        <a href="{{ route('profile.show', $user->id) }}"   class="text-decoration-none  text-white">
                                            <i class="fas fa-user-circle user-icon text-black" id="user_icon"></i>
                                        </a>
                                    @endif
                                    <span id="search-user-name">{{ $user->name }}</span>
                                    <a href="{{ route('chat.showChat', $user->id) }}" class="btn text-end"id="searched-chat-button">
                                        <p class="m-0">Chat</p>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- searched post area --}}
                @if($search_posts->isNotEmpty())
                    @foreach($search_posts as $post)
                        @if($post->user_id != Auth::user()->id && $post->role_id != 2 && $post->status != 2)
                        <div class="card mb-3 mx-auto bg-dark text-white border" id="searched-posts">
                            <div class="card-header p-0 ms-2 mt-2" id="post_header">
                                <div class="row w-100">
                                    <div class="col-auto pe-0">
                                        @if($post->user->avatar)
                                            <a href="{{ route('profile.show', $post->user->id) }}"      class="text-decoration-none  text-white">
                                                <img src="data:image/png;base64,{{ $post->user->avatar }}" alt="    {{      $post->user->avatar }}" class="rounded-circle nav-avatar"   id="user_img">
                                            </a>
                                        @else
                                            <a href="{{ route('profile.show', $post->user->id) }}"      class="text-decoration-none  text-white">
                                                <i class="fas fa-user-circle user-icon" id="user_icon"></i>
                                            </a>
                                        @endif
                                    </div>
                                    <div class="col-auto text-start ps-2" id="post_detail">
                                        <a href="{{ route('profile.show', $post->user->id) }}"      class="text-decoration-none text-white">
                                            {{ $post->user->name }}
                                        </a>
                                    </div>
                                    <div class="col" id="post_detail">
                                        <p class="text-info mt-1 ps-3">{{ $post->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>

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
                                        <p class="mt-2 w-75" id="sp_description">
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
                        </div>
                        @endif
                    @endforeach
                @endif
        </div>
    </div>
</div>
@endsection


