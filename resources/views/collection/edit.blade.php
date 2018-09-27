
@extends('layouts.app')

@section('title')
{{__('message.collection_edit').' - '}}
@endsection

@section('content')

<div class="container">
  <div class="medium-panel">
    <div class="panel-heading">
      <label class="heading">{{$collection->name}}</label>
    </div>

      <collection-edit col-slug="{{$collection->slug}}" col-name="{{$collection->name}}" col-description="{{$collection->description}}" col-visibility="{{$collection->visibility}}" image-src="{{$collection->getImage()}}"></collection-edit>
      <div class="panel-heading">
        <label class="full-label heading">{{__('message.photo_upload')}}</label>
      </div>

      <div class="alert-box info light">
        <label class="font-bold">{{ __('message.photo_limit', ['amount' => '10']) }}</label><br>
        <sub class="arial"><small class="fas fa-asterisk font-red"></small>&nbsp;{{ __('message.collection_ratio', ['ratio' => '16:9', 'size' => '768px*432px']) }}</sub>
      </div>

      <collection-dropzone col-id="{{$collection->id}}" col-slug="{{$collection->slug}}"></collection-dropzone>
      <div class="panel-heading">
        <label class="full-label heading">{{__('message.products')}}</label>
      </div>
      <collection-product-edit col-id="{{$collection->id}}" col-slug="{{$collection->slug}}"></collection-product-edit>

  </div>
</div>

@endsection
