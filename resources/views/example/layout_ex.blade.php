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
  <meta property="og:url" content="{{ url()->full() }}">
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
    <link href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/main.css?v=1.0" rel="stylesheet">
  @else
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
  @endif
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
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
  <style media="screen">
  .alert-box {
    font-family: 'Arial', sans-serif !important;
    margin: 0 10px;
  }
  sub {
    font-family: 'Arial', sans-serif !important;
  }
  </style>
</head>
<body>

  <div id="app">
    <div class="medium-panel" style="padding: 10px 0">
      <div class="alert-box help">
        <h3 class="no-margin">ตัวอย่างร้าน</h3>
        **ข้อความที่อยู่ในกรอบแบบนี้จะไม่แสดงในหน้าร้านจริง
      </div>
    </div>
      @yield('content')
  </div>

</body>
</html>
