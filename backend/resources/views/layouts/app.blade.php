<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link href="{{ asset('css/img.css') }}" rel="stylesheet">
    <link href="{{ asset('css/post_show.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link href="{{ asset('css/search.css') }}" rel="stylesheet">
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">


    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div id="app">
        <div class="nav_container shadow-sm border border-none">
            <div class="row w-100">
                @guest
                    <div class="col">
                        @if (Route::has('login'))
                                <a class="nav-link " id="login" href="{{ route('login') }}">{{ __('Login') }}</a>
                        @endif
                    </div>
                    <div class="col">
                        @if (Route::has('register'))
                                <a class="nav-link" id="register" href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
                    </div>
                @else
                    <div class="col d-block d-lg-none">
                        <button class="btn btn-sm" type="button" data-bs-toggle="collapse" href="#collapseSearch" role="button" >
                            <i class="fas fa-search" id="nav_search_icon"></i>
                        </button>
                    </div>
                    <div class="collapse" id="collapseSearch">
                        <div class="search-box" id="nav_search">
                            <form action="{{ route('search') }}" method="get">
                                @csrf
                                <input type="text" name="search" class="form-element " placeholder="キーワード検索" id="nav_search_box" required>
                                <button class="btn btn-sm btn-primary">検索</button>
                            </form>
                        </div>
                    </div>
                    <div class="col">
                        <a href="{{ route('index') }}" id="home_icon" >
                            <i class="fa-solid fa-house text-secpmdary icon"></i>
                        </a>
                    </div>
                    <div class="col">
                        <a href="{{ route('post.create') }}" id="create_icon" class="text-primary">
                            <img src="../../images/nav_img.jpg" style="height:43px; width:43px;">
                        </a>
                    </div>
                    <div class="col">
                        <button class="btn shadow-none nav-link" id="account-dropdown"  data-bs-toggle="dropdown">
                            @if(Auth::user()->avatar)
                                <img src="data:image/png;base64,{{ Auth::user()->avatar }}" alt="{{   Auth::user()->avatar }}" class="rounded-circle nav-avatar"  id="nav_user_avatar">
                            @else
                                <i class="fa-solid fa-circle-user nav-icon" id="nav_user_icon"></i>
                            @endif
                        </button>

                        <div class="dropdown-menu dropdown-menu-end mt-5" aria-labelledby="navbarDropdown" id="nav_drop">
                            <!-- profile -->
                                <a href="{{ route('profile.show', Auth::user()->id) }}"     class="dropdown-item">
                                    <i class="fa-solid fa-circle-user">Profile</i>
                                </a>
                            {{-- record --}}
                                <a href="{{ route('user_post.create') }}" class="dropdown-item">
                                    <i class="fa-solid fa-album">記録</i>
                                </a>
                            <!-- logout -->
                            <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-right-from-bracket"></i> {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"     class="d-none">
                                @csrf
                            </form>
                    </div>
                @endif
            </div>
        </div>

        <main class="mt-3">
            @yield('content')
        </main>
    </div>
</body>
</html>
