@extends('layouts.app')

@section('title')
{{__('message.product_edit').' - '}}
@endsection

@section('css')
    <link href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/extra/dropzone-alt.css" rel="stylesheet">
@endsection

@section('content')

    <div class="container">
        <div class="medium-panel">
        <div class="panel-heading">
          <label class="full-label heading">{{__('message.product_edit')}}</label>
        </div>
            <product-edit product-slug="{{$product->uid}}"
            product-name="{{$product->name}}"
            product-price="{{$product->price}}"
            product-description="{{$product->description}}"
            product-visibility="{{$product->visibility}}"
            image-src="{{$product->getImage()}}">
            </product-edit>

            <div class="panel-heading">
              <label class="full-label heading">{{ __('message.photo_upload') }}</label>
            </div>
          	<div class="alert-box info margin-30-horizontal margin-20-top">
          		<label><span class="icon-notification"></span>&nbsp;{{ __('message.photo_limit', ['amount' => '7']) }}</label>
          	</div>

            <product-dropzone product-slug="{{$product->uid}}" product-id="{{$product->id}}"></product-dropzone>
        <div class="panel-heading">
          <label class="full-label heading">{{__('message.choice')}}</label>
        </div>
        <product-choice product-slug="{{$product->uid}}"></product-choice>

        </div>
    </div>

@endsection
