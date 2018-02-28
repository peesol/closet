<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title'){{config('app.name') }}</title>

    <!-- Styles -->
    <link href="{{asset('css/all.css')}}" rel="stylesheet">
    {{-- <link href="{{asset('css/main.css')}}" rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Athiti" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/balloon-css/0.5.0/balloon.min.css">
    @yield('css')
    <!-- Scripts -->
    <script src="{{asset('js/manifest.js')}}"></script>
    <script src="{{asset('js/vendor.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <script>
window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};

window.Closet = {
    url:'{{ config('app.url') }}',
    locale:'{{ App::getLocale() }}',
        user:{
            authenticated: {{ Auth::check() ? 'true' : 'false'}},
            user: {{ Auth::check() ? Auth::user()->id : 'null' }}
        }
    };
    </script>

    @yield('scripts')
</head>
<body>
  <div class="overlay"></div>
    <div id="app">

        @include('layouts.partials._navigation')

        @yield('content')

    </div>
<footer></footer>
</body>
</html>
