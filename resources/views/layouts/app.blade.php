<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.meta')
    <title>{{ config('app.name', 'Joy 自學中心') }}</title>
    <link rel="icon" href="{{ asset('J.ico') }}" type="image/x-icon">


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    首頁
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                                <!-- 顯示用戶點數 -->
                                <span class="text-info ms-2">(點數: {{ Auth::user()->points }})</span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <!-- 如果用戶是 admin，顯示創建產品的選項 -->
                                @if (auth()->user() && auth()->user()->isAdmin())
                                <a class="dropdown-item" href="{{ route('products.create') }}">
                                    {{ __('Create Product') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('products.index') }}">
                                    {{ __('Edit Products') }}
                                </a>
                                @endif
                                <!-- 我的訂單 -->
                                <a class="dropdown-item" href="{{ route('orders.index') }}">
                                    {{ __('My orders') }}
                                </a>
                                <!-- 登出選項 -->
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <!-- 登出表單 -->
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>

                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- 彈出錯誤訊息的區塊 -->
        @if(session('error'))
        <script>
            alert("{{ session('error') }}");
        </script>
        @endif

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>