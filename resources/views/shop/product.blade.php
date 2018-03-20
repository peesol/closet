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
                          @include('thumbnail._products',[ 'product' => $product ])
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
