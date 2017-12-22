    @extends('layouts.app')
    @section('title')
    {{__('message.collection_edit').' - '}}
    @endsection
    @section('css')
        <link href="{{ asset('css/dropzone-alt.css') }}" rel="stylesheet">
    @endsection
    @section('scripts')
        <script>
          window.addEventListener('load', function () {
                var edit = new Vue({
                  el: '.product-show-panel',
                  data: {
                    colId: '{{$collection->id}}',
                    colSlug: '{{$collection->slug}}'
                  }
                });
            });
        </script>
    @endsection
    @section('content')
<div class="container">
            <div class="product-show-panel">
                <div class="panel-heading"><h3 class="no-margin">{{$collection->name}}</h3></div>

                <collection-edit col-name="{{$collection->name}}" col-description="{{$collection->description}}" col-visibility="{{$collection->visibility}}" image-src="{{$collection->getImage()}}"></collection-edit>
                <collection-dropzone></collection-dropzone>
                <collection-product-edit></collection-product-edit>
            </div>
</div>

@endsection
