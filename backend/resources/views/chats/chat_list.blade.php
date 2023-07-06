@extends('layouts.app')

@section('title','ChatList')

@section('content')
<div class="chat-list-page pt-3">
    @if($chattedUsers->isNotEmpty())
        <div class="card " id="chat-list">
            <div class="card-header text-white">
                <h5 class="card-title">チャットリスト</h5>
            </div>
            <ul class="list-group list-group-flush">
                @foreach($chattedUsers as $chatUser)
                    @if($chatUser->id !== Auth::user()->id)
                        <li class="list-group-item">
                            <a href="{{ route('chat.showChat', $chatUser->id) }}"   class="text-dark">
                                @if($chatUser->avatar)
                                    <img src="data:image/png;base64,{{ $chatUser->avatar }}" alt="  {{ $chatUser->avatar }}" class="rounded-circle nav-avatar"    id="chat_list_user_avatar">
                                @else
                                    <i class="fa-solid fa-circle-user nav-icon"></i>
                                @endif
                                <span>{{ $chatUser->name }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    @else
        <div class="card mt-3 w-50 mx-auto">
            <div class="card-body text-center">
                <i class="fas fa-comments text-success mb-3" id="chat-icon"></i>
                <h5 class="card-title text-muted">チャット履歴がありません</h5>
            </div>
        </div>
    @endif
</div>
@endsection
