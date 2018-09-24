@extends('layouts.app')
@section('title')
{{$shop->name.' - '}}
@endsection
@section('content')

<div class="container">
            @if($shop->count())
            <div class="medium-panel">
              @include('shop.partials._header',[
                  'shop' => $shop
              ])

                    <div class="tab-nav">
                        <ul class="tab-nav-ul static">
                          <button class="tab-nav-btn" onclick='document.location.href="/{{$shop->slug}}"'><i class="fas fa-home"></i><font>{{__('message.home')}}</font></button>
                          <button class="tab-nav-btn current"><i class="fas fa-shopping-bag"></i><font>{{__('message.product')}}</font></button>
                          <button class="tab-nav-btn" onclick='document.location.href="/{{$shop->slug}}/collection"'><i class="fas fa-map"></i><font>{{__('message.collection')}}</font></button>
                          <button class="tab-nav-btn" onclick='document.location.href="/{{$shop->slug}}/about"'><i class="fas fa-user"></i><font>{{__('message.about')}}</font></button>
                          <button class="tab-nav-btn" onclick='document.location.href="/{{$shop->slug}}/reviews"'><i class="fas fa-star"></i><font>{{__('message.review')}}</font></button>
                        </ul>
                    </div>
                    <div class="panel-heading-alt">
                      <h3 class="no-margin font-grey">{{__('message.products')}}&nbsp;({{$products->count()}})</h3>
                    </div>
                    @if ($products->count())
                      <div class="panel-body thumbnail-grid">
                        @foreach ($products as $product)
                          @include('thumbnail._products',[ 'product' => $product ])
                        @endforeach
                      </div>
                    @else
                      <div class="align-center padding-30-bottom">
                        <h2 class="font-grey">{{__('message.no_shop_product')}}</h2>
                      </div>
                    @endif
                </div>

            </div>
@endif

</div>

@endsection
