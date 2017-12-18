@extends('layouts.app')
@section('title')
{{$product->name}}
@endsection
@section('css')
<link href="{{ asset('css/slick-theme.css') }}" rel="stylesheet">
<link href="{{ asset('css/slick.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script type="text/javascript" src="{{asset('js/slick.min.js')}}"></script>
@endsection
@section('content')

<div class="container">
            <div class="product-show-panel">
                <div class="panel-heading"><p class="product-title">{{__('message.product_name')}} : {{ $product->name }}</p></div>
                <div class="panel-body-alt flex">
                    <div class="product-showcase">
                        @foreach ($product->productimages as $productimage)
                                <img src="{{config('closet.buckets.images') . '/product/photo/' . $productimage->filename}}">
                        @endforeach
                    </div>

                    <div class="product-details">
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
                            <collection-product product-id="{{ $product->id }}" shop-slug="{{Auth::check() ? Auth::user()->shop->slug : 'null'}}"></collection-product>
                        </div>
                        <div style="padding: 15px 15px;">
                            <p class=""><span class="font-bold grey-font">{{__('message.price')}}</span> : <span class="font-bold font-large">{{ number_format($product->price) }}</span> {{__('message.baht')}}</p>
                            <h3 class="{{ $product->stock ? 'green-font' : 'red-font'}}" style="margin: 10px 0px;">{{ $product->stock ? __('message.instock') : __('message.outstock')}}</h3>
                            <h4 class="no-margin {{ $product->shipping_free ? 'green-font' : 'not-display'}}">{{__('message.free_shipping')}}</h4>
                            <p class="no-margin"><span class="font-bold grey-font">{{__('message.shipping')}}</span> : {{ $product->shipping ? $product->shipping : __('message.undefined') }}</p>
                            <p class="no-margin {{ $product->shipping_free ? 'not-display' : ''}}"><span class="font-bold grey-font">{{__('message.shipping_fee')}}</span> : {{ $product->shipping_fee ? $product->shipping_fee.'&nbsp;'.__('message.baht') : __('message.undefined') }}</p>
                            <p class="no-margin"><span class="font-bold grey-font">{{__('message.shipping_time')}}</span> : {{ $product->shipping_time ? $product->shipping_time.'&nbsp;'.__('message.days') : __('message.undefined') }}</p>
                        </div>

                        <add-to-cart
                        product-id="{{ $product->id }}"
                        product-slug="{{ $product->uid }}">
                      </add-to-cart>
                    </div>
                </div>
            </div>
                <div class="product-show-panel" style="margin-top: 10px;">
                    <div class="shop-nav-bar">
                        <ul class="shop-nav-ul">
                            <button class="product-nav-btn current" data-tab="tab-1">{{__('message.details')}}</button>
                            <button class="product-nav-btn" data-tab="tab-2">{{__('message.comment')}}</button>
                            <button class="product-nav-btn" data-tab="tab-3">{{__('message.contact')}}</button>
                        </ul>
                    </div>
                        <div class="tab-content flex current"  style="padding: 15px 30px;" id="tab-1">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                        <div class="comment tab-content flex" id="tab-2">
                            <product-comment product-uid="{{ $product->uid }}"></product-comment>
                        </div>
                        <div class="comment tab-content flex" id="tab-3">
                            <p>Contact info</p>
                        </div>

                </div>

</div>
<script>
$('.product-showcase').slick({
    dots: true
});

window.addEventListener('load', function () {
    var comment = new Vue({
      el: '.comment',
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
