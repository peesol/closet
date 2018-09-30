<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:title" content="@yield('title'){{config('app.name') }}">
    <meta property="og:image" content="https://s3-ap-southeast-1.amazonaws.com/files.closet/etc/FB_sharing_closet.jpg">
    <meta property="og:description" content="ซื้อขายเสื้อผ้า สินค้าแฟชั่น เครื่องสำอาง อาหารเสริม เปิดร้านออนไลน์ฟรี">

    <title>@yield('title'){{config('app.name') }}</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Athiti" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/balloon-css/0.5.0/balloon.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    @yield('css')
    <!-- Scripts -->
    @if (App::environment('production'))
      <link href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/main.css" rel="stylesheet">
      <script src="https://s3-ap-southeast-1.amazonaws.com/files.closet/js/manifest.js"></script>
      <script src="https://s3-ap-southeast-1.amazonaws.com/files.closet/js/vendor.js"></script>
      <script src="https://s3-ap-southeast-1.amazonaws.com/files.closet/js/main.js"></script>
    @else
      <link rel="stylesheet" href="{{ asset('css/main.css') }}">
      <script src="{{ asset('js/manifest.js') }}"></script>
      <script src="{{ asset('js/vendor.js') }}"></script>
      <script src="{{ asset('js/main.js') }}"></script>
    @endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    @yield('scripts')
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
    <script>
      window.addEventListener('load', function () {
        document.querySelector('.res-search-btn').addEventListener('click', function () {
           this.classList.toggle('clicked');
           document.querySelector('.search-form').classList.toggle('display');
           document.querySelector('.res-search-btn').classList.toggle('icon-search');
           document.querySelector('.res-search-btn').classList.toggle('icon-cross');
        });
      })
    </script>
</head>
<body>
  <div class="overlay"></div>
    <div id="app" v-cloak>

        @include('layouts.partials._navigation')

        @yield('content')

        @include('layouts.partials._footer')
    </div>

</body>
</html>
