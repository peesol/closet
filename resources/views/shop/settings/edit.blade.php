@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="login-panel">
                <div class="panel-heading"><h3 class="no-margin">Closet edit</h3></div>

                <div class="panel-body">

                  <form action="/{{ $shop->slug }}/edit" method="post" enctype="multipart/form-data">

                           <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                               <label class="form-label" for="name">Name</label>
                               <input type="text" class="form-input" id="name" name="name" value="{{ old('name') ? old('name') : $shop->name }}">
                               @if ($errors->has('name'))
                                   <div class="help-block">
                                       {{ $errors->first('name') }}
                                   </div>
                               @endif
                           </div>

                           <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                                <label class="form-label" for="slug">Unique URL</label>
                                <div class="input-group">
                                    <span class="input-addon">{{ config('app.url') }}/</span>
                                    <input type="text" class="input-addon-field" id="slug" name="slug" value="{{ old('slug') ? old('slug') : $shop->slug }}">
                                </div>
                                @if ($errors->has('slug'))
                                    <div class="help-block">
                                        {{ $errors->first('slug') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                    <label class="form-label" for="description">Description</label>
                                    <textarea name="description" id="description" class="description-input">{{ old('description') ? old('description') : $shop->description }}</textarea>

                                    @if ($errors->has('description'))
                                        <div class="help-block">
                                            {{ $errors->first('description') }}
                                        </div>
                                    @endif
                            </div>

                            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                    <label class="form-label" for="image">Shop image</label>
                                    <input type="file" name="image" id="image">
                            </div>

                            <button class="login-btn" type="submit">Update</button>

                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
   $(".description-input").on('keydown', function() {
  var scroll_height = $(".description-input").get(0).scrollHeight;

  $(".description-input").css('height', scroll_height + 'px');
  });
});
</script>
@endsection
