@extends('layouts.app')

@section('title')
{{__('message.edit').' '.$product->name.' - '}}
@endsection

@section('css')
  <link href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/extra/dropzone-alt.css" rel="stylesheet">
@endsection

@section('content')

<div class="container">
  <div class="product-show-panel">
    <div class="panel-heading">
      <h4 class="no-margin">{{__('message.product_edit')}}</h4>
    </div>
      <product-edit product-slug="{{$product->uid}}"
        product-name="{{$product->name}}"
        product-price="{{$product->price}}"
        product-description="{{$product->description}}"
        image-src="{{$product->getImage()}}">
      </product-edit>
      <product-dropzone product-slug="{{$product->uid}}" product-id="{{$product->id}}"></product-dropzone>
  </div>
</div>

@endsection
