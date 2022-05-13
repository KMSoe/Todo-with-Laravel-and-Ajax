<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <!-- header start -->
        <header class="w-100 bg-secondary">
            <div class="container">
                <nav class="">
                    <div class="row g-0">
                        <div class="col-12 col-lg-12">
                            <div class="main-nav d-flex">
                                <div class="ms-2">
                                    <a href="/" class="navbar-brand ms-2 text-white text-bold">
                                        {{ config('app.name', 'Laravel') }}
                                    </a>
                                </div>

                                <ul class="nav py-2">
                                    <!-- Authentication Links -->
                                    @guest
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                    @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                    @endif
                                    @endguest

                                    @auth
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            <img src='{{ asset("storage/profiles/profile.svg") }}' alt="{{ Auth::user()->name }}" class="img-fluid profile-img"> <span class="username text-white px-2 py-2 d-none d-lg-inline-block">{{ Auth::user()->name }}</span>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                    @endauth
                                </ul>
                            </div>

                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <!-- header end -->

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>

</html>