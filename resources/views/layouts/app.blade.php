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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
{{--     TODO: Fix in modals --}}
    <link href="https://vjs.zencdn.net/7.17.0/video-js.css" rel="stylesheet" />
    <link href="https://www.unpkg.com/videojs-hls-quality-selector@1.0.5/dist/videojs-hls-quality-selector.css" rel="stylesheet" />

    <script src="https://vjs.zencdn.net/7.17.0/video.min.js"></script>
    <script src="https://unpkg.com/@videojs/http-streaming@2.13.1/dist/videojs-http-streaming.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-quality-levels/2.1.0/videojs-contrib-quality-levels.min.js" integrity="sha512-IcVOuK95FI0jeody1nzu8wg/n+PtQtxy93L8irm+TwKfORimcB2g4GSHdc0CvsK8gt1yJSbO6fCtZggBvLDDAQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://www.unpkg.com/videojs-hls-quality-selector@1.0.5/dist/videojs-hls-quality-selector.min.js"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @livewireStyles
    <style>
{{--       TODO: Move to css file                --}}
        [x-cloak] {
            display: none !important;
        }
    </style>


{{--    TODO: npm --}}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
</head>
<body style="background-image:url('{{asset('bg.png')}}')">
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
            @auth
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
                            <a class="dropdown-item px-4" href="{{ route('settings') }}">Settings</a>
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item px-4" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    this.closest('form').submit();">Log Out</a>
                            </form>
                        </div>
                    </li>
                </ul>
                @endauth
            </div>
        </div>
    </nav>

    <header class="d-flex py-3 bg-white shadow-sm border-bottom">
        <div class="container">
            @yield('title')
        </div>
    </header>

    <main class="">
        @yield('content')
    </main>

    <livewire:modals/>
    @livewireScripts
    @flasher_render <!-- this render all flasher notifications. -->
    @flasher_livewire_render <!-- this render livewire notifications only. -->
    <script>
        $(document).ready(function(){
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>

</body>
</html>
