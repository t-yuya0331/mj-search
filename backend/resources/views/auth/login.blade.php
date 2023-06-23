<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="login-page">
        <h2 class="text-center" id="title"> 麻雀マッチ</h2>
        {{-- Register Form --}}
        <div class="form">
            <form method="POST" action="{{ route('register') }}" class="register-form">
                @csrf
                <input type="text" placeholder="User Name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="username" autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <input type="email" placeholder="Email Address" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <input type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <input  type="password" placeholder="Confirmation Password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                <p class="control-label mb-1">あなたのレベルを選んでください</p>
                    <div class="form-check-inline">
                        <input type="radio" name="status" id="begginer" value="1" class="mb-0">
                        <label for="begginer">初級</label>
                    </div>
                    <div class="form-check-inline">
                        <input type="radio" name="status" id="intermediate" value="2" class="mb-0">
                        <label for="intermediate">中級</label>
                    </div>
                    <div class="form-check-inline">
                        <input type="radio" name="status" id="advanced" value="3" class="mb-0">
                        <label for="advanced">上級</label>
                    </div>

                    @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <p class="mt-2">
                        <a data-bs-toggle="collapse" href="#collapseTarget" aria-expanded="false" aria-controls="collapseTarget" id="target">
                            目安はこちら
                        </a>
                    </p>
                    <div class="collapse" id="collapseTarget">
                        <div class="target text-start">
                            <p class="rule mb-0">初級:&nbsp; 麻雀の基本ルールを覚えている方</p>
                            <p class="rule mb-0">中級:&nbsp; 基本ルールと点数計算を覚えている方</p>
                            <p class="rule mb-0">上級:&nbsp; 捨て牌、安全牌等を読み攻め時と引き時を実行に移せる方</p>
                        </div>
                    </div>

                    <button class="mt-3">create</button>
                    <p class="message">すでにアカウントをお持ちの方
                        <a class="toggle-form" data-target="login-form">Sign In</a>
                    </p>

                    <p class="text-center mt-3">Googleアカウントでログインする
                        <a href="{{ route('google.redirect') }}" >
                            <img src="images/google.png" alt="google_image" id="google_img">
                        </a>
                    </p>
            </form>

            {{-- Login Form  --}}
            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf
                    <input type="text" placeholder="Email Address" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <input type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required >
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <button>Login</button>
                    <p class="message">アカウントを作る
                        <a class="toggle-form" data-target="register-form">Create an account</a>
                    </p>

                    <p class="text-center mt-3">Googleアカウントでログインする
                        <a href="{{ route('google.redirect') }}" >
                            <img src="images/google.png" alt="google_image" id="google_img">
                        </a>
                    </p>

            </form>
        </div>
    </div>

<script>
    $('.message a').click(function(){
        $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
});
</script>
</body>
</html>
