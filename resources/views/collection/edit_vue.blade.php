    @extends('layouts.app')
    @section('css')
        <link href="{{ asset('css/dropzone-alt.css') }}" rel="stylesheet">
    @endsection
    @section('scripts')
        <script>
          window.addEventListener('load', function () {
                var edit = new Vue({
                  el: '.product-show-panel'
                });
            });
        </script>
    @endsection
    @section('content')
<div class="container">
            <div class="product-show-panel">
                <div class="panel-heading"><h3 class="no-margin">{{$collection->name}}</h3></div>

                <collection-edit col-slug={{$collection->slug}} col-name="{{$collection->name}}" col-description="{{$collection->description}}" col-visibility="{{$collection->visibility}}" image-src="{{$collection->getImage()}}"></collection-edit>
                <collection-dropzone col-id="{{$collection->id}}" col-slug={{$collection->slug}}></collection-dropzone>
                <collection-product-edit col-id="{{$collection->id}}"></collection-product-edit>
            </div>
</div>

@endsection
