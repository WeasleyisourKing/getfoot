<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/image/favicon_1.ico">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>Admin - Pulse</title>

    <!-- Styles -->
    <link href="{{ asset('lib/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/pages.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/components.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/menu.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/core.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/icons.css') }}" rel="stylesheet">

</head>
<body>
<div id="app">
    <nav class="navbar ">
        <div class="container">
            <div class="navbar-header">

            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @guest
                    {{--<li><a href="{{ route('login') }}">Login</a></li>--}}
                    {{--<li><a href="{{ route('logout') }}">logout</a></li>--}}
                    @else
                        <li class="dropdown">
                            {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">--}}
                                {{--管理员 <span class="caret"></span>--}}
                            {{--</a>--}}

                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        退出登录
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @endguest
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
</div>

<!-- Scripts -->
{{--<script src="{{ asset('js/app.js') }}"></script>--}}
</body>
</html>
