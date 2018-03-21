@extends('layouts.app')

@section('title')
{{$collection->name.' - '}}
@endsection

@section('css')
    <link rel="stylesheet" href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/extra/slick-theme.css"/>
    <link rel="stylesheet" href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/extra/slick.css"/>
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

                <div class="panel-body">
                  <label class="heading full-label">{{__('message.description')}}</label>
                </div>

                @if ($collection->description != null)
                	<div class="padding-15-bottom padding-30-horizontal" id="full-line">
                		<p class="no-margin">{{$collection->description}}</p>
                	</div>
                @else

                <div class="panel-body" id="full-line">
                	<p>{{__('message.no_description')}}</p>
                </div>

                @endif

                <div class="panel-body">
                  <label class="heading full-label">{{__('message.featured_product')}}</label>
                </div>


                    @if($products->count())

                        <div class="panel-body thumbnail-grid">
                        @foreach($products as $product)
                          <div class="products-wrap">
                            <div class="products-img">
                                <a href="/product/{{ $product->uid}}">
                                <img class="products-img-thumb" src="{{$product->getImage()}}" alt="{{$product->thumbnail}}">
                                </a>
                                @if($product->discount_price)
                                <span class="discount">Sale</span>
                                <span class="price">
                                  <strike>{{ number_format($product->price) }}&#3647;</strike>
                                  {{ number_format($product->discount_price) }}&#3647;
                                </span>
                                @else
                                <span class="price">{{ number_format($product->price) }}&#3647;</span>
                                @endif
                            </div>

                            <h4 class="product-name">
                              <a class="link-text" href="/product/{{ $product->uid}}">{{ $product->name }}</a>
                            </h4>

                            <div class="product-detail-wrap">
                              @if (!$product->discount_price)
                              <p class="product-p">{{__('message.price')}} : {{ number_format($product->price) }}&#3647;</p>
                              @else
                              <p class="product-p">
                                {{__('message.price')}}&nbsp;:&nbsp;<strike>{{ number_format($product->price) }}&#3647;</strike>
                                <small class="icon-next-arrow grey-font"></small>
                                <font class="font-green">{{ number_format($product->discount_price) }}&#3647;</font>
                              </p>
                              @endif
                              @if($product->type->id !== 1)
                                <p class="product-p">{{__('message.category')}} : {{ $product->type->showTranslate(App::getLocale())->name}}</p>
                              @else
                                <p class="product-p">{{__('message.category')}} : {{$product->subcategory->showTranslate(App::getLocale())->name}}</p>
                              @endif
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
