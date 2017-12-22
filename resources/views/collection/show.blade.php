@extends('layouts.app')

@section('title')
{{$collection->name.' - '}}
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/col-slick-theme.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/col-slick.css') }}"/>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script>
window.addEventListener('load', function () {
      var edit = new Vue({
        el: '#product-show'
      });
  });
</script>
@endsection

@section('content')
<div class="container">
            <div class="large-panel">
                <div class="panel-heading"><h3 class="no-margin">{{$collection->name}}</h3></div>
                @if ($collection->images->count())
                	<div style="padding: 30px 50px;">
                		  <div class="col-carousel">
                	        @foreach ($collection->images as $image)
                	            <img src="{{config('closet.buckets.images') . '/collection/photo/' . $image->filename}}">
                	        @endforeach
                	    </div>
                	</div>
                @else
                	<div class="panel-body"><p>{{__('message.no_image')}}</p></div>
                @endif
        		<div id="full-line"></div>
                <div class="panel-heading">
                	<h3 class="no-margin">{{__('message.description')}}</h3>
                </div>
                @if ($collection->description != null)
                	<div class="panel-body">
                		<p class="no-margin">{{$collection->description}}</p>
                	</div>
                	<div id="full-line"></div>
                @else
                	<div class="panel-body">
                		<p>{{__('message.no_description')}}</p>
                	</div>
                	<div id="full-line"></div>
                @endif

                <div id="product-show">
                <collection-product-show col-id="{{$collection->id}}"></collection-product-show>
                </div>
            </div>
</div>

</div>
    <script>
      $('.col-carousel').slick({
        slidesToShow: 1,
        dots: true,
      });
    </script>
@endsection
