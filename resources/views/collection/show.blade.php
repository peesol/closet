@extends('layouts.app')

@section('title')
{{$collection->name.' - '}}
@endsection
@section('og-image')
  @if (count($collection->images))
  <meta property="og:image" content="https://s3-ap-southeast-1.amazonaws.com/files.closet/collection/photo/{{$collection->images->first()->filename}}">
  @else
  <meta property="og:image" content="https://s3-ap-southeast-1.amazonaws.com/files.closet/collection/thumbnail/{{ $collection->thumbnail ? $collection->thumbnail : 'default.jpg' }}">
  @endif
@endsection
@section('og-description')
{{$collection->description ? $collection->description : 'คอลเล็คชั่น ' . $collection->name}}
@endsection
@section('content')
<div class="container">
  <div class="large-panel">
      <div class="panel-heading">
        <label class="heading full-label">{{$collection->name}}</label>
      </div>
      @if ($collection->images->count())
      	<div class="collection-slide-wrap">
          <vue-slick :imgs="{{json_encode($collection->images)}}" path="/collection/photo/" slick-for="collection"></vue-slick>
      	</div>
      @else
      	<div class="panel-body" id="full-line"><p>{{__('message.no_image')}}</p></div>
      @endif

      @if ($collection->description != null)
        <div class="padding-15-horizontal">
          <label class="heading full-label">{{__('message.description')}}</label>
        </div>
      	<div class="padding-15-bottom padding-30-horizontal" id="full-line">
      		<p class="no-margin">{{$collection->description}}</p>
      	</div>
        <div class="panel-body" id="full-line">
          <p>{{__('message.no_description')}}</p>
        </div>
      @else

      @endif

  <div class="panel-body">
    <label class="heading full-label">{{__('message.featured_product')}}</label>
  </div>

  <div class="panel-body thumbnail-grid">
    @if ($products->count())
      @foreach ($products as $product)
        @include('thumbnail._products',[ 'product' => $product ])
      @endforeach
    @else
      <label>{{__('message.no_shop_product')}}</label>
    @endif
  </div>
</div>

</div>
@endsection
