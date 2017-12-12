@extends('layouts.app')

@section('content')
    <div class="container">
                <div class="listing-panel">
                    <div class="panel-heading"><h3 class="no-margin">Product Listing</h3></div>
                    <div class="panel-body">
                            @if(session('status'))
                                <div class="alert"> 
                                {{ session('status') }}
                                </div>
                            @endif
                        <form action="/sell/product" role="form" method="post" enctype="multipart/form-data">

                        
                        <div class="form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">
                            <label class="form-label" for="name">Product name</label>
                            <input type="text" class="form-input" id="name" name="name" >
                                @if ($errors->has('product_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('product_name') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label class="form-label" for="price">Price</label>
                            <input type="text" class="form-input" id="price" name="price">
                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label class="form-label" for="decription">Decription</label>
                            <textarea class="description-input" id="description" name="description"></textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                            <label class="form-label" for="category_id">Category</label>
                            <select class="select-input" name="category_id" id="category_id">
                            <option value="" selected disabled>Please select</option>
                            @foreach($categories as $category)
                            {
                                <option value="{{ $category->id }}"> {{ $category->name }} </option>
                            }
                            @endforeach
                            </select>
                                @if ($errors->has('category_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('subcategory_id') ? ' has-error' : '' }}">
                            <label class="form-label" for="subcategory_id">Subcategory</label>
                            <select class="select-input" name="subcategory_id" id="subcategory_id">

                                <option value=""></option>

                            </select>
                                @if ($errors->has('subcategory_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('subcategory_id') }}</strong>
                                    </span>
                                @endif
                        </div>

                         <div class="form-group">
                         <label class="form-label">Product image</label>
                             <div class="dropzone" id="myDropzone"></div>
                         </div>
                                
                        <button id="submit-all" class="login-btn" type="submit">List</button>

                        
                            {{ csrf_field() }}
                            {{ method_field('POST') }}
                        </form>
                    </div>
                    </div>
                </div>
    </div>

<script src="{{ asset('js/img-upload.js') }}"></script>



<script>
Dropzone.options.myDropzone= {
    url: '/sell/product',
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 5,
    maxFiles: 5,
    maxFilesize: 2,
    acceptedFiles: 'image/*',
    addRemoveLinks: true,
    paramName: "image",
    headers: {
                    'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,
                },
    init: function() {

        dzClosure = this; // Makes sure that 'this' is understood inside the functions below.
                    this.on('addedfile', function(file) {
                        if (this.files.length > 5) {
                            this.removeFile(this.files[0]);
                            }
                        });
        // for Dropzone to process the queue (instead of default form behavior):
        document.getElementById("submit-all").addEventListener("click", function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
            dzClosure.processQueue();
        });

        //send all the form data along with the files:
        dzClosure.on("sendingmultiple", function(data, xhr, formData) {
            formData.append("product_name", jQuery("#product_name").val());
            formData.append("price", jQuery("#price").val());
            formData.append("description", jQuery("#description").val());
            formData.append("category_id", jQuery("#category_id").val());
            formData.append("subcategory_id", jQuery("#subcategory_id").val());
        });
        dzClosure.on("queuecomplete", function() {
            toastr.success('Success.');
            window.location.replace("{{config('app.url')}}/sell/product");
        });

    },

}

$(document).ready(function() {
    $('#category_id').on('change',function(e){

        var category_id = e.target.value;
        //get data file from url and this data called data  
        $.get('/sell/subcat/' + category_id, function(data){
    
                $('#subcategory_id').empty();
    
                $.each(data, function(index, subcatObj){
                $('#subcategory_id').append('<option value="'+subcatObj.id +'">'+subcatObj.name+'</option>')
                });
        });
    });
});
    
</script>

@endsection