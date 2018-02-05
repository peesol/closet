@extends('layouts.app')
@section('title')
{{$shop->name.' - '}}
@endsection
@section('css')
<link href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/extra/slick-theme.css" rel="stylesheet">
<link href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/extra/slick.css" rel="stylesheet">
@endsection
@section('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

@endsection

@section('content')

<div class="container">
          @if($shop->count())
            <div class="shop-panel">
              @include('shop.partials._header',[
                  'shop' => $shop
              ])

                    <div class="tab-nav">
                        <ul class="tab-nav-ul">
                            <button class="tab-nav-btn static current"><span class="icon-home"></span><font>{{__('message.home')}}</font></button>
                            <button class="tab-nav-btn static" onclick='document.location.href="/{{$shop->slug}}/products"'><span class="icon-silhouette"></span><font>{{__('message.product')}}</font></button>
                            <button class="tab-nav-btn static" onclick='document.location.href="/{{$shop->slug}}/collection"'><span class="icon-map"></span><font>{{__('message.collection')}}</font></button>
                            <button class="tab-nav-btn static" onclick='document.location.href="/{{$shop->slug}}/about"'><span class="icon-user"></span><font>{{__('message.about')}}</font></button>
                        </ul>
                    </div>
                    <div class="panel-body" id="full-line">
                      @if($shop->description)
                      <p>{!! nl2br(e($shop->description)) !!}</p>
                      @endif
                      @if($shop->contact->count())
                      <div>
                        @foreach($shop->contact as $contact)
                          <div class="full-label" style="height:40px">
                            @if($contact->link)
                              <span class="contact-btn {{$contact->type}} icon-{{$contact->type}}"></span>&nbsp;
                              <a class="link-text" href="{{$contact->link}}">{{$contact->body}}</a>
                            @else
                              <span class="contact-btn {{$contact->type}} icon-{{$contact->type}}"></span>&nbsp;<label class="grey-font font-light">{{$contact->body}}</label>
                            @endif
                          </div>
                        @endforeach
                      </div>
                      @endif
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
