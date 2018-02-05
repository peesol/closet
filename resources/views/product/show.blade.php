@extends('layouts.app')
@section('title')
{{$product->name.' - '}}
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
    @if(!Auth::check())
    <div class="product-show-panel">
      <div class="panel-body" id="full-line">
        <div class="alert-box info">
          <h3 class="no-margin">
            <span class="icon-notification"></span>
            {{__('auth.login_notice')}}<a class="link-text font-bold" href="{{ route('login')}}">&nbsp;{{__('message.login')}}</a>
            {{__('auth.login_notice2')}}<a class="link-text font-bold" href="{{ route('register')}}">&nbsp;{{__('message.register')}}</a>
          </h3>
        </div>
      </div>
    </div>
    @endif
            <div class="product-show-panel">
                <div class="panel-heading"><p class="product-title">{{__('message.product_name')}} : {{ $product->name }}</p></div>
                <div class="panel-body-alt flex">
                    <div class="product-showcase">
                        @foreach ($product->productimages as $productimage)
                                <img src="{{config('closet.buckets.images') . '/product/photo/' . $productimage->filename}}">
                        @endforeach
                    </div>

                    <div class="product-details relative">
                        <div class="details-header">
                            <div class="thumb">
                            <a href="/{{ $product->shop->slug}}"><img src="{{ $product->shop->getThumbnail() }}" alt="{{ $product->shop->thumbnail }}" style="float: left; width: 50px;"></a>
                                <div class="shop-name-wrap">
                                <a class="shop-name" href="/{{ $product->shop->slug}}">{{ $product->shop->name }}</a>
                                </div>
                            </div>
                            <div class="follow-btn-wrapper">
                              <follow-button shop-slug="{{ $product->shop->slug}}"></follow-button>
                            </div>

                        </div>
                        <div class="details-header-sub">
                            <product-vote product-uid="{{ $product->uid }}" product-id="{{ $product->id }}"></product-vote>
                            @if($product->visibility == 'public')
                            <collection-product product-id="{{ $product->id }}" shop-slug="{{Auth::check() ? Auth::user()->shop->slug : null}}"></collection-product>
                            @endif
                        </div>
                        <div style="padding: 15px 15px;">
                            <p class="">
                              <span class="font-bold grey-font">{{__('message.price')}}</span>&nbsp;:&nbsp;
                              @if($product->discount_price)
                              <strike>{{ number_format($product->price) }}&#3647;</strike>
                              <small class="icon-next-arrow grey-font"></small>
                              <font class="font-bold font-large green-font">{{ number_format($product->discount_price) }}&#3647;</font>
                              @else
                              <font class="font-bold font-large">{{ number_format($product->price) }}</font>&#3647;
                              @endif
                            </p>
                            <h3 class="{{ $product->stock ? 'green-font' : 'red-font'}}" style="margin: 10px 0px;">{{ $product->stock ? __('message.instock') : __('message.outstock')}}</h3>
                            <h4 class="no-margin {{ $product->shipping_free ? 'green-font' : 'not-display'}}"><span class="icon-truck"></span>&nbsp;{{__('message.free_shipping')}}</h4>
                            <p class="no-margin"><span class="font-bold grey-font">{{__('message.shipping')}}</span> : {{ $product->shipping ? $product->shipping : __('message.undefined') }}</p>
                            <p class="no-margin {{ $product->shipping_free ? 'not-display' : ''}}"><span class="font-bold grey-font">{{__('message.shipping_fee')}}</span> : {{ $product->shipping_fee ? $product->shipping_fee.'&nbsp;'.__('message.baht') : __('message.undefined') }}</p>
                            <p class="no-margin"><span class="font-bold grey-font">{{__('message.shipping_time')}}</span> : {{ $product->shipping_time ? $product->shipping_time.'&nbsp;'.__('message.days') : __('message.undefined') }}</p>
                        </div>


                        @if(Auth::check())
                          @if(Auth::user()->id !== $product->shop_id)
                          <add-to-cart product-id="{{ $product->id }}" product-slug="{{ $product->uid }}"></add-to-cart>
                          @endif
                        @endif

                    </div>
                </div>
            </div>
                <div class="product-show-panel" style="margin-top: 10px;">
                    <div class="tab-nav">
                        <ul class="tab-nav-ul">
                            <button class="tab-nav-btn static current" data-tab="tab-1">{{__('message.details')}}</button>
                            <button class="tab-nav-btn static" data-tab="tab-2" id="tab-comment">{{__('message.comment')}}</button>
                        </ul>
                    </div>
                        <div class="tab-content flex current"  style="padding: 15px 30px;" id="tab-1">
                            @foreach($contacts as $contact)
                              <div class="full-label" style="height:40px">
                                @if($contact->link)
                                  <span class="contact-btn {{$contact->type}} icon-{{$contact->type}}"></span>&nbsp;
                                  <a class="link-text" href="{{$contact->link}}">{{$contact->body}}<sup>*</sup></a>
                                @else
                                  <span class="contact-btn {{$contact->type}} icon-{{$contact->type}}"></span>&nbsp;<label class="grey-font font-light">{{$contact->body}}</label>
                                @endif
                              </div>
                            @endforeach
                            <div class="panel-body">
                              <p class="comment">{!! nl2br(e($product->description)) !!}</p>
                            </div>
                        </div>
                        <div class="comment-vue tab-content flex" id="tab-2">
                          @if(!Auth::check())
                          <div class="alert-box info">
                            <h3 class="no-margin">
                              <span class="icon-notification"></span>
                              {{__('auth.comment_notice')}}<a class="link-text font-bold" href="{{ route('login')}}">&nbsp;{{__('message.login')}}</a>
                            </h3>
                          </div>
                          @endif
                          <product-comment product-uid="{{ $product->uid }}"></product-comment>
                        </div>

                </div>

</div>
<script>
$('.product-showcase').slick({
  lazyLoad: 'ondemand',
    dots: true,
});

$('#tab-comment').one('click', function() {
  var comment = new Vue({
    el: '.comment-vue',
    data: window.Closet
  });
});

$(document).ready(function(){
    $('ul.shop-nav-ul button').click(function(){
        var tab_id = $(this).attr('data-tab');
        $('ul.shop-nav-ul button').removeClass('current');
        $('.tab-content').removeClass('current');
        $(this).addClass('current');
        $("#"+tab_id).addClass('current');
    });

});
</script>

@endsection
