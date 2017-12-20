@extends('layouts.app')
@section('title')
{{__('message.product_edit').' - '}}
@endsection
@section('css')
    <link href="{{ asset('css/dropzone-alt.css') }}" rel="stylesheet">
@endsection
@section('scripts')
<script>
    window.addEventListener('load', function () {
        var follow = new Vue({
          el: '.container'
        });
    });
</script>
@endsection
@section('content')
    <div class="container">
        <div class="product-show-panel">
        <div class="panel-heading"><h4 class="no-margin">{{__('message.product_edit')}}</h4></div>
            <product-edit product-slug="{{$product->uid}}"
            product-name="{{$product->name}}"
            product-price="{{$product->price}}"
            product-description="{{$product->description}}"
            image-src="{{$product->getImage()}}">
            </product-edit>
            <div id="full-line"></div>
        <div class="panel-heading"><h4 class="no-margin">{{__('message.choice')}}</h4></div>
        <product-choice product-id="{{$product->id}}"></product-choice>
        <div id="full-line"></div>
        <div class="panel-heading"><h4 class="no-margin">{{__('message.shipping')}}</h4></div>
            <product-shipping shipping-info="{{$product->shipping}}"
              shipping-fee="{{$product->shipping_fee}}"
              shipping-time="{{$product->shipping_time}}"
              shipping-free="{{$product->shipping_free}}"
              shipping-inter="{{$product->shipping_inter}}"
              product-slug="{{$product->uid}}"
              ></product-shipping>
            <product-dropzone product-slug="{{$product->uid}}" product-id="{{$product->id}}"></product-dropzone>
        </div>
    </div>

@endsection
