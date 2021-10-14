<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DBR77 Platform</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
{{--    <script src="{{ asset('js/app.js') }}" defer></script>--}}
    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
    <style>
        body {

           font-family: 'Nunito Sans', sans-serif;
        }
        /*html {*/
        /*    margin-bottom: 130px !important;*/
        /*}*/
        .navbar-light .navbar-nav .nav-link {
            text-transform: uppercase;
            font-weight: bold;
            color: #3a2a68 !important;
            -webkit-transition: background-color 2s; /* For Safari 3.1 to 6.0 */
            transition: background-color 1s;
        }

        .navbar-light .navbar-nav .nav-link:hover {
            background-color: #3a2a68;
            color: #fff !important;
        }

        footer {
            /*position: absolute;*/
            /*width: 100%;*/
            /*bottom: 0;*/
            background: linear-gradient(270deg, #3a2a68, #8787ff);
            background-size: 400% 400%;

            -webkit-animation: gradientFooter 20s ease infinite;
            -moz-animation: gradientFooter 20s ease infinite;
            -o-animation: gradientFooter 20s ease infinite;
            animation: gradientFooter 20s ease infinite;
        }
        @-webkit-keyframes gradientFooter {
            0%{background-position:0% 50%}
            50%{background-position:100% 50%}
            100%{background-position:0% 50%}
        }
        @-moz-keyframes gradientFooter {
            0%{background-position:0% 50%}
            50%{background-position:100% 50%}
            100%{background-position:0% 50%}
        }
        @-o-keyframes gradientFooter {
            0%{background-position:0% 50%}
            50%{background-position:100% 50%}
            100%{background-position:0% 50%}
        }
        @keyframes gradientFooter {
            0%{background-position:0% 50%}
            50%{background-position:100% 50%}
            100%{background-position:0% 50%}
        }

        @-webkit-keyframes swing
        {
            15%
            {
                -webkit-transform: translateX(5px);
                transform: translateX(5px);
            }
            30%
            {
                -webkit-transform: translateX(-5px);
                transform: translateX(-5px);
            }
            50%
            {
                -webkit-transform: translateX(3px);
                transform: translateX(3px);
            }
            65%
            {
                -webkit-transform: translateX(-3px);
                transform: translateX(-3px);
            }
            80%
            {
                -webkit-transform: translateX(2px);
                transform: translateX(2px);
            }
            100%
            {
                -webkit-transform: translateX(0);
                transform: translateX(0);
            }
        }
        @keyframes swing
        {
            15%
            {
                -webkit-transform: translateX(5px);
                transform: translateX(5px);
            }
            30%
            {
                -webkit-transform: translateX(-5px);
                transform: translateX(-5px);
            }
            50%
            {
                -webkit-transform: translateX(3px);
                transform: translateX(3px);
            }
            65%
            {
                -webkit-transform: translateX(-3px);
                transform: translateX(-3px);
            }
            80%
            {
                -webkit-transform: translateX(2px);
                transform: translateX(2px);
            }
            100%
            {
                -webkit-transform: translateX(0);
                transform: translateX(0);
            }
        }
.bottom-menu li {
    float: left;
color: white;
    margin-left: 50px;
}
        .bottom-menu li a{
            color: #fff;
            font-weight: bold;
            /*text-transform: uppercase;*/
        }
        .bottom-menu {
            margin-top: 60px;
            list-style: none;
        }
    </style>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,900&display=swap&subset=latin-ext" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{url('images/logo_dbr.png')}}" class="logo"/>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('zaklady') }}">Zakłady</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('projektant') }}">Projektant</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('instalator') }}">Instalator</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('contact') }}">Kontakt</a>
                        </li>
{{--                        @guest--}}
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>--}}
{{--                            </li>--}}
{{--                            @if (Route::has('register'))--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>--}}
{{--                                </li>--}}
{{--                            @endif--}}
{{--                        @else--}}
{{--                            <li class="nav-item dropdown">--}}
{{--                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>--}}
{{--                                    {{ Auth::user()->name }} <span class="caret"></span>--}}
{{--                                </a>--}}

{{--                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">--}}
{{--                                    <a class="dropdown-item" href="{{ route('logout') }}"--}}
{{--                                       onclick="event.preventDefault();--}}
{{--                                                     document.getElementById('logout-form').submit();">--}}
{{--                                        {{ __('Logout') }}--}}
{{--                                    </a>--}}

{{--                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">--}}
{{--                                        @csrf--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            </li>--}}
{{--                        @endguest--}}
                    </ul>
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{url('images/unia_logo.jpg')}}" class="logo"/>
                    </a>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        <!-- Footer -->
    </div>
    <footer class="page-footer font-small blue pt-1">

        <!-- Footer Links -->
        <div class="container-fluid text-center text-md-left">
            <!-- Grid row -->
            <div class="row">
                <!-- Grid column -->
                <div class="col-md-2 col-12 offset-md-1">
                    <img src="{{url('s3/twopointo/logo_dbr_white.png')}}" style="max-width: 200px;width: 100%; padding: 30px"/>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-4 col-12 offset-md-5">
                    <ul class="bottom-menu">
                        <li><a href="{{url('start')}}">Start</a></li>
                        <li><a href="{{url('about')}}">O nas</a></li>
                        <li><a href="{{url('privacy')}}">Polityka prywatności</a></li>
                    </ul>
                </div>
                <!-- Grid column -->

            </div>
            <!-- Grid row -->

        </div>
        <!-- Footer Links -->
    </footer>
    <!-- Footer -->
    @yield('scripts')
</body>
</html>
