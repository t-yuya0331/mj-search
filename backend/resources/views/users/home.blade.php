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
                    <input type="text" name="search" class="form-element" placeholder="キーワード検索" required>
                    <button class="btn btn-sm"><i class="fas fa-search" id="search_icon"></i></button>
                </form>
            </div>
        </div>
</div>
@endsection
