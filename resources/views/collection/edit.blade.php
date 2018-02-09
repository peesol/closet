
@extends('layouts.app')

@section('title')
{{__('message.collection_edit').' - '}}
@endsection

@section('css')
    <link href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/extra/dropzone-alt.css" rel="stylesheet">
@endsection

@section('content')

<div class="container">
  <div class="product-show-panel">
    <div class="panel-heading"><h3 class="no-margin">{{$collection->name}}</h3></div>

      <collection-edit col-name="{{$collection->name}}" col-description="{{$collection->description}}" col-visibility="{{$collection->visibility}}" image-src="{{$collection->getImage()}}"></collection-edit>
      <collection-dropzone col-id="{{$collection->id}}" col-slug="{{$collection->slug}}"></collection-dropzone>
      <collection-product-edit col-id="{{$collection->id}}"></collection-product-edit>

  </div>
</div>

@endsection
