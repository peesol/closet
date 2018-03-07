@extends('layouts.app')

@section('title')
{{$collection->name.' - '}}
@endsection

@section('css')
    <link rel="stylesheet" href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/extra/slick-theme.css"/>
    <link rel="stylesheet" href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/extra/slick.css"/>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
@endsection

@section('content')
<div class="container">
            <div class="large-panel">
                <div class="panel-heading"><h3 class="no-margin">{{$collection->name}}</h3></div>
                @if ($collection->images->count())
                	<div style="padding: 30px 50px;">
                		  <div class="col-carousel">
                        <vue-slick :imgs="{{json_encode($collection->images)}}" path="/collection/photo/" slick-for="collection"></vue-slick>
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
                <div class="panel-heading">
                  <h3 class="no-margin">{{__('message.featured_product')}}</h3>
                </div>

                    @if($products->count())
                      <div class="thumbnail-grid margin-10-top">
                        @foreach($products as $product)
                        <div v-if="products.length" class="panel-body thumbnail-grid">
                            <div v-for="product in products" class="products-wrap">
                                <a  href="/product/{{ $product->uid}}">
                                  <img class="products-img-thumb" src="{{config('closet.buckets.images') . '/product/thumbnail/' . $product->thumbnail}}"alt="{{$product->thumbnail}} image"></a>
                                <div>
                                <h4 class="no-margin"><a class="link-text" :href="url + '/product/'+ product.uid" style="font-size:1.2em;">{{$product->name}}</a></h4>
                                <p class="no-margin">{{__('message.price')}}&nbsp:&nbsp{{$product->price}}</p>
                                <p class="no-margin">{{__('message.category')}}&nbsp:&nbsp{{$product->subcategory->showTranslate(App::getLocale())->name}}</p>
                                <p class="no-margin">{{__('message.by')}}&nbsp<a class="link-text" :href="url + '/'+ product.slug">{{$product->shop->name}}</a></p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                      </div>
                    @else
                  <div class="panel-body">
                      <p>{{__('message.no_shop_product')}}</p>
                  </div>
                  @endif

</div>

</div>
@endsection
