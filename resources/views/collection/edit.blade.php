
@extends('layouts.app')

@section('title')
{{__('message.collection_edit').' - '}}
@endsection

@section('css')
    <link href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/extra/dropzone-alt.css" rel="stylesheet">
@endsection

@section('content')

<div class="container">
  <div class="medium-panel">
    <div class="panel-heading">
      <label class="heading">{{$collection->name}}</label>
    </div>

      <collection-edit col-slug="{{$collection->slug}}" col-name="{{$collection->name}}" col-description="{{$collection->description}}" col-visibility="{{$collection->visibility}}" image-src="{{$collection->getImage()}}"></collection-edit>
      <div class="panel-heading">
        <label class="full-label heading">{{__('message.product_edit')}}</label>
      </div>
      <div class="alert-box info margin-30-horizontal margin-20-top">
        <span class="icon-notification"></span>&nbsp; photolimit
      </div>
      <collection-dropzone col-id="{{$collection->id}}" col-slug="{{$collection->slug}}"></collection-dropzone>
      <div class="panel-heading">
        <label class="full-label heading">{{__('message.products')}}</label>
      </div>
      <collection-product-edit col-id="{{$collection->id}}"></collection-product-edit>

  </div>
</div>

@endsection
