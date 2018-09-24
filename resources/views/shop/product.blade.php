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
                          <button class="tab-nav-btn" onclick='document.location.href="/{{$shop->slug}}"'><span class="icon-home"></span><font>{{__('message.home')}}</font></button>
                          <button class="tab-nav-btn current"><span class="icon-silhouette"></span><font>{{__('message.product')}}</font></button>
                          <button class="tab-nav-btn" onclick='document.location.href="/{{$shop->slug}}/collection"'><span class="icon-map"></span><font>{{__('message.collection')}}</font></button>
                          <button class="tab-nav-btn" onclick='document.location.href="/{{$shop->slug}}/about"'><span class="icon-user"></span><font>{{__('message.about')}}</font></button>
                          <button class="tab-nav-btn" onclick='document.location.href="/{{$shop->slug}}/reviews"'><span class="icon-star-full"></span><font>{{__('message.review')}}</font></button>
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
