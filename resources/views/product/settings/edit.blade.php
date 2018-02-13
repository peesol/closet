@extends('layouts.app')

@section('title')
{{__('message.product_edit').' - '}}
@endsection

@section('css')
    <link href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/extra/dropzone-alt.css" rel="stylesheet">
@endsection

@section('content')

    <div class="container">
        <div class="product-show-panel">
        <div class="panel-heading"><label class="full-label no-margin">{{__('message.product_edit')}}</label></div>
            <product-edit product-slug="{{$product->uid}}"
            product-name="{{$product->name}}"
            product-price="{{$product->price}}"
            product-description="{{$product->description}}"
            product-visibility="{{$product->visibility}}"
            image-src="{{$product->getImage()}}">
            </product-edit>
            <div id="full-line"></div>
        <div class="panel-heading"><label class="full-label no-margin">{{__('message.choice')}}</label></div>
        <product-choice product-slug="{{$product->uid}}"></product-choice>
        <div id="full-line"></div>
        <div class="panel-heading"><label class="full-label no-margin">{{__('message.shipping')}}</label></div>
            <shipping-edit shipping-info="{{$product->shipping}}"
              shipping-fee="{{$product->shipping_fee}}"
              shipping-time="{{$product->shipping_time}}"
              shipping-free="{{$product->shipping_free}}"
              shipping-inter="{{$product->shipping_inter}}"
              product-slug="{{$product->uid}}"
              ></shipping-edit>
            <product-dropzone product-slug="{{$product->uid}}" product-id="{{$product->id}}"></product-dropzone>
        </div>
    </div>

@endsection
