<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dropzone-alt.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}"/>

    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
window.Closet = {
    url:'{{ config('app.url') }}',
    user:{
    user: {{ Auth::check() ? Auth::user()->id : 'null' }},
    authenticated: {{ Auth::check() ? 'true':'false'}}
    }
    };
    </script>
</head>
<body>
    <div class="overlay"></div>
    <div id="app">
    @include('layouts.partials._navigation')

<div class="container">
            <div class="product-show-panel">
                <div class="panel-heading"><h3 class="no-margin">{{$collection->name}} Edit</h3></div>
                <div class="panel-body" id="col-edit">
                	<collection-edit col-slug={{$collection->slug}} col-name="{{$collection->name}}" col-description="{{$collection->description}}" col-visibility="{{$collection->visibility}}" image-src="{{$collection->getImage()}}"></collection-edit>
                </div>
                <div class="panel-heading" id="col-photo-toggle" style="border-top: 1px solid #efefef;"><h4 class="no-margin">Collection Photo</h4></div>
                <div class="panel-body">
                	<div class="col-photo">
                		<label class="col-label">Collection photo</label>
                		<div class="dropzone" id="myDropzone"></div>
                		<button class="col-photo-submit" id="photo-submit">Submit</button>
                	</div>                	
                </div>

                	<div id="full-line"></div>


</div>

<script src="{{ asset('js/img-upload.js') }}"></script>
<script>
	Dropzone.autoDiscover = false;
	window.addEventListener('load', function () {
        var edit = new Vue({
          el: '#col-edit'
        });
        var collectionId = {{ $collection->id }};
		var myDropzone = new Dropzone(".dropzone", {
		  	url: '/collection/upload/' + collectionId,                        
		  	autoProcessQueue: false,
		  	uploadMultiple: true,
		    parallelUploads: 10,
		    maxFiles: 10,
		    maxFilesize: 2,
		    acceptedFiles: 'image/*',
		    addRemoveLinks: true,
		    paramName: "image",
		    headers: {'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,},
		    init: function() {
 					this.on('addedfile', function(file) {
  						if (this.files.length > 10) {
   							this.removeFile(this.files[0]);
  							}
 						});
					},
			queuecomplete: function() {
        		toastr.success("Success.");
    				},
    		success: function() {
    			this.removeFile(this.files[0]);
    		}
		}); 

		$('#photo-submit').click(function(){
		  myDropzone.processQueue();
		});
    });
$(document).ready(function(){
    $("#col-photo-toggle").click(function(e){
    	e.preventDefault();
          $(".col-photo").toggleClass("height-toggled");
          $(".col-photo").toggleClass("opacity-toggled");
    }); 
});
</script>
    </div>

</body>
</html>