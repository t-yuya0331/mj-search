@extends('layouts.app')

@section('title','Create Post')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title">チャットリスト</h5>
        </div>
        <ul class="list-group list-group-flush">
            @foreach($chattedUsers as $chatUser)
                @if($chatUser->id !== Auth::user()->id)
                    <li class="list-group-item">
                        <a href="{{ route('chat.showChat', $chatUser->id) }}" class="text-dark">
                            @if($chatUser->avatar)
                                <img src="data:image/png;base64,{{ $chatUser->avatar }}" alt="{{ $chatUser->avatar }}" class="rounded-circle nav-avatar"  id="chat_list_user_avatar">
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
</div>
@endsection
