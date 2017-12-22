@extends('layouts.app')
@section('title')
{{$product->name.' - '}}
@endsection
@section('css')
<link href="{{ asset('css/slick-theme.css') }}" rel="stylesheet">
<link href="{{ asset('css/slick.css') }}" rel="stylesheet">
<style>
#info{
  padding: 15px 15px;
  height: auto;
}
  @media (min-width: 768px) {
    #info{
      height: calc(100% - 153px);
    }
  }
</style>
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
                        @foreach ($product->productimages as $image)
                                <img src="{{config('closet.buckets.images') . '/used/photo/' . $image->filename}}" alt="{{$image->filename}}">
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
                        <div style="padding: 15px 15px;">
                          <h3 class="no-margin red-font">{{__('message.used')}}</h3>
                            <p class="no-margin"><span class="font-bold grey-font">{{__('message.price')}}</span> : <span class="font-bold font-large">{{ number_format($product->price) }}</span> {{__('message.baht')}}</p>
                        </div>

                        <div id="info">
                        {!! nl2br(e($product->description)) !!}
                        </div>

                    </div>
                </div>
            </div>
                <div class="product-show-panel" style="margin-top: 10px;">
                    <div class="shop-nav-bar">
                        <ul class="shop-nav-ul">
                            <button class="product-nav-btn" data-tab="tab-2">{{__('message.comment')}}</button>
                            <button class="product-nav-btn" data-tab="tab-3">{{__('message.contact')}}</button>
                        </ul>
                    </div>
                        <div class="tab-content flex current"  style="padding: 15px 30px;" id="tab-1">

                        </div>
                        <div class="comment tab-content flex" id="tab-2">
                            <used-comment product-uid="{{ $product->uid }}"></used-comment>
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
    var details = new Vue({
      el: '.product-details'
    });
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
