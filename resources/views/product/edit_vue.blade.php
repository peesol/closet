@extends('layouts.app')
@section('title')
{{__('message.edit').' '.$product->name.' - '}}
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
            <product-dropzone product-slug="{{$product->uid}}" product-id="{{$product->id}}"></product-dropzone>
        </div>
    </div>

@endsection
