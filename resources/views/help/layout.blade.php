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
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    @yield('script')
    <style media="screen">
      i {
        color: #6c6c6c;
      }
    </style>
</head>
<body>
  <nav>
    <div class="nav-container color-heading">
      <div class="align-center">
        <a href="/">
          <img class="main-logo" src="https://s3-ap-southeast-1.amazonaws.com/files.closet/etc/logo_white.svg" alt="">
        </a>
      </div>
    </div>
  </nav>
<div class="container" style="margin-top: 70px">
  <div class="large-panel">
    @yield('content')
  </div>
</div>

</body>
</html>
