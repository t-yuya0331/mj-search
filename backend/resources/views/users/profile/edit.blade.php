@extends('layouts.app')

@section('title', 'Edit Profie')

@section('content')

<div class="container">


        <form action="{{ route('profile.update', $user->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
            <div class="mb-3">
                <label for="avatar" class="form-label">Profile Picture</label>
            @if($user->avatar)
                <img src="data:image/png;base64,{{ Auth::user()->avatar }}" alt="{{ Auth::user()->avatar }}" class="rounded-circle nav-avatar" id="nav_user_avatar">
            @else
                <i class="fa-solid fa-user-circle text-dark" id="icon"></i>
            @endif
                <input type="file" name="avatar" id="avatar" class="form-control" value="{{ $user->avatar }}">

                @error('avatar')
                <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" >

                @error('name')
                <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}">

                @error('email')
                <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="introduction" class="form-label">Introduction</label>
                <textarea name="introduction" id="introduction" cols="30" rows="5" class="form-control" >{{ $user->introduction }}</textarea>

                @error('introduction')
                <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <div class="">
                <button type="submit" class="btn btn-primary w-100">Save</button>
            </div>

        </form>
</div>

@endsection
