@extends('layouts.app')

@section('title')
{{__('message.product_edit').' - '}}
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

            <div class="alert-box info light">
              <label class="font-bold">{{ __('message.photo_limit', ['amount' => '7']) }}</label><br>
              <sub class="arial"><small class="fas fa-asterisk font-red"></small>&nbsp;{{ __('message.product_ratio', ['ratio' => '1:1', 'size' => '500px*500px']) }}</sub>
            </div>

            <product-dropzone product-slug="{{$product->uid}}" product-id="{{$product->id}}"></product-dropzone>
        <div class="panel-heading">
          <label class="full-label heading">{{__('message.choice')}}</label>
        </div>
        <product-choice product-slug="{{$product->uid}}"></product-choice>

        </div>
    </div>

@endsection
