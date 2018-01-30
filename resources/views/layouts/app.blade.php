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
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Athiti" rel="stylesheet">

    @yield('css')
    <!-- Scripts -->
    <script src="{{asset('js/manifest.js')}}"></script>
    <script src="{{asset('js/vendor.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <script>
window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};

window.Closet = {
    url:'{{ config('app.url') }}',
    locale:'{{ App::getLocale() }}',
        user:{
            user: {{ Auth::check() ? Auth::user()->id : 'null' }},
            authenticated: {{ Auth::check() ? 'true':'false'}},
        }
    };
    </script>
    @yield('scripts')
</head>
<body style="font-family: Roboto, Athiti, sans-serif;">
    <div class="overlay"></div>
    <div id="app">

        @include('layouts.partials._navigation')

        @yield('content')

    </div>
<footer></footer>
</body>
<style media="screen">
  button{
    font-family: Roboto, Athiti, sans-serif;
  }
</style>
</html>
