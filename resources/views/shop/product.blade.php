@extends('layouts.app')
@section('title')
{{$shop->name.' - '}}
@endsection
@section('content')

<div class="container">
            @if($shop->count())
            <div class="shop-panel">
              @include('shop.partials._header',[
                  'shop' => $shop
              ])

                    <div class="tab-nav">
                        <ul class="tab-nav-ul">
                          <button class="tab-nav-btn static" onclick='document.location.href="/{{$shop->slug}}"'><span class="icon-home"></span><font>{{__('message.home')}}</font></button>
                          <button class="tab-nav-btn static current"><span class="icon-silhouette"></span><font>{{__('message.product')}}</font></button>
                          <button class="tab-nav-btn static" onclick='document.location.href="/{{$shop->slug}}/collection"'><span class="icon-map"></span><font>{{__('message.collection')}}</font></button>
                          <button class="tab-nav-btn static" onclick='document.location.href="/{{$shop->slug}}/about"'><span class="icon-user"></span><font>{{__('message.about')}}</font></button>
                        </ul>
                    </div>
        <div style="padding: 15px 45px;"><h3 class="no-margin">{{__('message.products')}}&nbsp;({{$products->count()}})</h3></div>
            <div class="panel-body thumbnail-grid">
                    @if ($products->count())
                        @foreach ($products as $product)

                        <div class="products-wrap s-products-margin">
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
                              <h4 class="product-name"><a class="link-text" href="/product/{{ $product->uid}}">{{ $product->name }}</a></h4>
                          <div class="product-detail-wrap">
                            @if (!$product->discount_price)
                            <p class="product-p">{{__('message.price')}} : {{ number_format($product->price) }}&#3647;</p>
                            @else
                            <p class="product-p">
                              {{__('message.price')}}&nbsp;:&nbsp;<strike>{{ number_format($product->price) }}&#3647;</strike>
                              <small class="icon-next-arrow grey-font"></small>
                              <font class="green-font">{{ number_format($product->discount_price) }}&#3647;</font>
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
                    @else
                    <h3 style="text-align: center; margin:50px auto;">{{__('message.no_shop_product')}}</h3>
                    @endif
                    </div>
                </div>

            </div>
@endif

</div>

@endsection
