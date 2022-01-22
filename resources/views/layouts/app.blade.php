<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-light bg-white border-bottom sticky-top">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="/">
                <img src="{{ asset('logo.svg') }}" height="30rem">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            Dashboard
                        </a>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav">
                    <!-- Settings Dropdown -->
                    <li class="nav-item dropdown">
                        <a id="settingsDropdown" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->username }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end animate slideIn" aria-labelledby="settingsDropdown">
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item px-4" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    this.closest('form').submit();">Log Out</a>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <header class="d-flex py-3 bg-white shadow-sm border-bottom">
        <div class="container">
            @yield('title')
        </div>
    </header>

    <main class="py-4">
        @yield('content')
    </main>

</body>
</html>
