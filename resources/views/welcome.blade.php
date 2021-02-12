<!DOCTYPE html>
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
    <link rel="stylesheet" href="https://getbootstrap.com/docs/4.3/examples/cover/cover.css">
</head>
{{--            @if (Route::has('login'))--}}
{{--                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">--}}
{{--                    @auth--}}
{{--                        <a href="{{ url('/users') }}" class="text-sm text-gray-700 underline">Home</a>--}}
{{--                    @else--}}
{{--                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>--}}

{{--                        @if (Route::has('register'))--}}
{{--                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>--}}
{{--                        @endif--}}
{{--                    @endauth--}}
{{--                </div>--}}
{{--            @endif--}}
<body class="text-center">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <header class="masthead mb-auto">
{{--            <div class="inner">--}}
{{--                <h3 class="masthead-brand">User CRUD</h3>--}}
{{--                <nav class="nav nav-masthead justify-content-center">--}}
{{--                    <a class="nav-link active" href="#">Home</a>--}}
{{--                    <a class="nav-link" href="#">Features</a>--}}
{{--                    <a class="nav-link" href="#">Contact</a>--}}
{{--                </nav>--}}
{{--            </div>--}}
        </header>

        <main role="main" class="inner cover">
            <h1 class="display-1">User CRUD</h1>
            <p class="lead">An application created by <a href="https://www.linkedin.com/in/morgy" target="_blank" class="text-primary">Morgan Gonzales</a> as an assessment for the Senior Laravel Developer position.</p>
            <p class="lead">
                <i class="fab fa-github"></i> <a href="https://github.com/MorganGonzales/user-crud" class="badge badge-primary">Code-base</a> |
                <i class="fas fa-user-circle"></i> <a href="https://drive.google.com/file/d/1JnpQwCaJRf_VPiHFFvTktyLKn03rlWZZ/view?usp=sharing" class="badge badge-pill badge-secondary">My CV</a> |
                <i class="fab fa-linkedin"></i> <a href="https://www.linkedin.com/in/morgy" class="badge badge-pill badge-success">My Profile</a>
            </p>
            <p class="lead">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/users') }}" class="btn btn-lg btn-secondary">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-lg btn-primary">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-lg btn-secondary">Register</a>
                        @endif
                    @endauth
                @endif
            </p>
        </main>

        <footer class="mastfoot mt-auto">
            <div class="inner">
                <p>Cover template for <a href="https://getbootstrap.com/">Bootstrap</a>, by <a
                        href="https://twitter.com/mdo">@mdo</a>.</p>
            </div>
        </footer>
    </div>
</body>
</html>
