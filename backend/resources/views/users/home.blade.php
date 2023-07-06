@extends('layouts.app')

@section('content')
<div class="home-page  pt-3">
    <div class="row w-100 m-0">
        {{-- search on sm screen --}}
        <div class="row">
            <div class="col d-block d-lg-none">
                <button class="btn btn-sm" type="button" data-bs-toggle="collapse" href="#collapseSearch" role="button" >
                    <i class="fas fa-search" id="sm-search-icon"></i>
                </button>
            </div>
            <div class="collapse" id="collapseSearch">
                <div class="search-box" id="nav_search">
                    <form action="{{ route('search') }}" method="get">
                        @csrf
                        <input type="text" name="search" class="form-element " placeholder="キーワード検索" id="sm-search-box" required>
                        <button class="btn btn-sm btn-primary" id="sm-search-button" >検索</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
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
            <div class="col mt-5 d-md-none d-xl-block" id="suggestion">
                <div class="row">
                    <div class="search-box" id="search">
                        <form action="{{ route('search') }}" method="get">
                            @csrf
                            <input type="text" name="search" class="form-element bg-white"placeholder="キーワード検索" required>
                            <button class="btn btn-sm"><i class="fas fa-search"id="search_icon"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
