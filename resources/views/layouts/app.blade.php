<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @hasSection('og-image')
  <meta property="og:title" content="@yield('og-title')">
  @else
  <meta property="og:title" content="@yield('title'){{config('app.name') }}">
  @endif
  @hasSection('og-image')
    <meta property="og:image" content="@yield('og-image')">
  @else
    <meta property="og:image" content="https://s3-ap-southeast-1.amazonaws.com/files.closet/etc/FB_sharing_closet.jpg">
  @endif
  @hasSection('og-description')
    <meta property="og:description" content="@yield('og-description')">
  @else
    <meta property="og:description" content="ซื้อขายเสื้อผ้า สินค้าแฟชั่น เครื่องสำอาง อาหารเสริม เปิดร้านออนไลน์ฟรี">
  @endif
  @yield('og-catalog')
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
  <!-- Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-127032353-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-127032353-1');
  </script>
  <!-- Facebook Pixel Code -->
  <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '2274345159451987');
    fbq('track', 'PageView');
  </script>
  <noscript>
    <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=2274345159451987&ev=PageView&noscript=1"/>
  </noscript>
</head>
<body>
  @yield('fb-events')
  <div class="overlay"></div>
    <div id="app" v-cloak>

        @include('layouts.partials._navigation')

        @yield('content')

        @include('layouts.partials._footer')
    </div>

</body>
</html>
