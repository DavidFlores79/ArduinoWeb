<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" ng-app="@yield('ngApp')">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Hope') }} | @yield('page-title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/brand/favicon.ico')}}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-4.6.1/bootstrap.min.css') }}">
    <!-- FontAwesome -->
    <link href="{{ asset('css/fontawesome/all.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <!-- Bootstrap Select  -->
    <link href="{{ asset('css/bootstrap-select-1.13.14/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ng-table.min.css') }}" rel="stylesheet">
    <!-- AngularJS -->
    <script src="{{ asset('js/angular-1.8.2/angular.min.js') }}"></script>
    <!-- Constants JS -->
    <script src="{{ asset('js/constantes.js') }}"></script>
    <!-- Loading  -->
    <link href="{{ asset('css/loading.css') }}" rel="stylesheet">
    <!-- DatePicker -->
    <link href="{{ asset('css/jquery-ui-1.13.1/jquery-ui.css') }}" rel="stylesheet">
    <!-- Sweet Alert -->
    <script src="{{ asset('js/sweetalert2.1.2/sweetalert.min.js') }}"></script>
    <!-- Moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <!-- ChartJs -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
    @yield('styles')

</head>

<body ng-controller="@yield('ngController')">

    <!-- Loading -->
    <div class="loading d-none align-items-center justify-content-center " id="loading">
        <div class="box">
            <div class="out"></div>
            <div class="mid"></div>
            <div class="in"></div>
            <p class="loading-legend">Cargando</p>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('img/brand/arduino_logo.png') }}" alt="Arduino Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto"></ul>
            <ul class="navbar-nav pr-3">
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
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>




    </nav>
    <main class="py-4">
        @yield('content')
    </main>

    <script src="{{ asset('js/jquery-3.5.1/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui-1.13.1/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/bootstrap-4.6.1/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('js/dirPagination.js') }}"></script>
    <script src="{{ asset('js/ng-table.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select-1.13.14/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.serializejson.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <!-- Angular File -->
    @yield('ngFile')
    <!-- Scripts -->
    @yield('scripts')
</body>

</html>