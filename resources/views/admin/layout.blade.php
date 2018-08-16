<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title'){{config('app.name') }}</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <!-- Styles -->
    <link href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/main.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    @yield('css')
    <!-- Scripts -->
    @yield('script')
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
</head>
<body>
  <div class="overlay"></div>
    <div id="app">

        @yield('content')

    </div>
<footer></footer>
</body>
</html>
