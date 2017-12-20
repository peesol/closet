@extends('layouts.app')
@section('title')
{{$shop->name.' - '}}
@endsection
@section('css')
<link href="{{ asset('css/carousel-slick-theme.css') }}" rel="stylesheet">
<link href="{{ asset('css/carousel-slick.css') }}" rel="stylesheet">
@endsection
@section('scripts')

<script type="text/javascript" src="{{asset('js/slick.min.js')}}"></script>

@endsection

@section('content')

<div class="container">
          @if($shop->count())
            <div class="shop-panel">
              @include('shop.partials._header',[
                  'shop' => $shop
              ])

                    <div class="shop-nav-bar">
                        <ul class="shop-nav-ul">
                            <button class="product-nav-btn-active">{{__('message.home')}}</button>
                            <button class="product-nav-btn" onclick='document.location.href="/{{$shop->slug}}/products"'>{{__('message.product')}}</button>
                            <button class="product-nav-btn" onclick='document.location.href="/{{$shop->slug}}/collection"'>{{__('message.collection')}}</button>
                            <button class="product-nav-btn" onclick='document.location.href="/{{$shop->slug}}/about"'>{{__('message.about')}}</button>
                        </ul>
                    </div>
            <div style="padding: 15px 45px;">

                    @if ($showcases->count())
                        @foreach ($showcases as $showcase)
                          <div class="no-border-heading margin-bot-10px"><h3 class="no-margin">{{$showcase->name}}</h3></div>
                          <div class="shop-carousel">

                            @include('shop.partials._showcase',[
                                'showcase' => $showcase
                            ])

                          </div>
                        @endforeach
                    @else
                      @if($populars->count())
                      <div class="no-border-heading margin-bot-10px"><h3 class="no-margin">{{__('message.popular')}}</h3></div>
                      <div class="shop-carousel">

                          @foreach ($populars as $product)

                          @include('shop.partials._carousel',[
                              'product' => $product
                              ])

                          @endforeach
                        @else
                        <h3 style="text-align: center; margin:50px auto;">{{__('message.no_shop_product')}}</h3>
                        @endif

                    @endif

                    </div>

                </div>

            </div>
            @endif

</div>

<script>
$('.shop-carousel').slick({
  infinite: false,
  speed: 300,
  slidesToShow: 5,
  slidesToScroll: 5,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 4,
        infinite: false,
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});
</script>
<script>
window.addEventListener('load', function () {
    var follow = new Vue({
      el: '.shop-header'
    });
    var vote = new Vue({
      el: '.shop-vote'
    });
});
</script>
@endsection
