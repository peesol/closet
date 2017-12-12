@extends('layouts.app')

@section('content')
    <div class="container">
                <div class="listing-panel">
                    <div class="panel-heading">Product Listing</div>
                    <div class="panel-body">
                    @if(session()->has('message.level'))
                        <div class="alert alert-{{ session('message.level') }}"> 
                        {!! session('message.content') !!}
                        </div>
                    @endif
                        <form action="/product/{{ $product->uid}}/edit" role="form" method="post" enctype="multipart/form-data">

                        
                        <div class="form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">
                            <label class="form-label" for="product_name">Product name</label>
                            <input type="text" class="form-input" id="product_name" name="product_name" value="{{ old('product_name') ? old('product_name') : $product->product_name }}" >
                                @if ($errors->has('product_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('product_name') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label class="form-label" for="price">Price</label>
                            <input type="text" class="form-input" id="price" name="price" value="{{ old('price') ? old('price') : $product->price }}">
                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label class="form-label" for="decription">Decription</label>
                            <textarea class="description-input" id="description" name="description">
                                {{ old('description') ? old('description') : $product->description }}
                            </textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                        </div>

                                
                        <button id="submit-all" class="login-btn" type="submit">Save changes</button>

                        
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                        </form>
                    </div>
                    </div>
                </div>
    </div>


@endsection