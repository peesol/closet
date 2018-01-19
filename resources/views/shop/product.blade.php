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

                    <div class="shop-nav-bar">
                        <ul class="shop-nav-ul">
                            <button type="submit" class="product-nav-btn" onclick='document.location.href="/{{$shop->slug}}"'>{{__('message.home')}}</button>
                            <button type="submit" class="product-nav-btn-active">{{__('message.product')}}</button>
                            <button type="submit" class="product-nav-btn" onclick='document.location.href="/{{$shop->slug}}/collection"'>{{__('message.collection')}}</button>
                            <button type="submit" class="product-nav-btn" onclick='document.location.href="/{{$shop->slug}}/about"'>{{__('message.about')}}</button>
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
                              <span class="discount-price">
                                <p class="no-margin"><strike>{{ number_format($product->price) }}&#3647;</strike></p>
                                <p class="no-margin">{{ number_format($product->discount_price) }}&#3647;</p>
                              </span>
                              @endif
                              @if($product->visibility === 'unlisted')
                              <span class="private icon-private" style="font-size:25px;"></span>
                              @endif
                          </div>
                              <h3 class="product-name"><a class="link-text" href="/product/{{ $product->uid}}">{{ $product->name }}</a></h3>
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
<script>
    window.addEventListener('load', function () {
        var follow = new Vue({
          el: '.shop-header'
        });
        var vote = new Vue({
          el: '.shop-vote',
          data: {
            url: '{{config('app.url')}}'
          }
        });
    });
</script>
@endsection
