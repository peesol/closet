<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title'){{config('app.name') }}</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link href="https://fonts.googleapis.com/css?family=Athiti" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
  </head>
  <style media="screen">
    body {
      background: #fff;
    }
    .container {
      padding: 0;
      width: 100%;
      text-align: center;
      background: transparent;
    }
    .message {
      padding-top: 150px;
    }
    h1, h2, h3 {
      color: #6c6c6c;
    }
    @media (min-width: 768px) {
      .container {
        width: 100%;
        margin: 0 auto;
      }
    }
  </style>
  <body>
    <div class="container">
      <div class="padding-5 message">
        @yield('contents')
        <h3 class="align-center"><a href="{{route('home')}}" class="link-text font-15em"><small class="fas fa-caret-left"></small>&nbsp;{{ __('error.home_route') }}</a></h3>
      </div>
    </div>
  </body>
</html>
