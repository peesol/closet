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
                  <button class="tab-nav-btn" onclick='document.location.href="/{{$shop->slug}}/products"'><span class="icon-silhouette"></span><font>{{__('message.product')}}</font></button>
                  <button class="tab-nav-btn" onclick='document.location.href="/{{$shop->slug}}/collection"'><span class="icon-map"></span><font>{{__('message.collection')}}</font></button>
                  <button class="tab-nav-btn" onclick='document.location.href="/{{$shop->slug}}/about"'><span class="icon-user"></span><font>{{__('message.about')}}</font></button>
                  <button class="tab-nav-btn current"><span class="icon-star-full"></span><font>{{__('message.review')}}</font></button>
                </ul>
            </div>

            <div class="panel-heading-alt">
              <label class="heading">{{__('message.review')}}</label>
            </div>

            <div class="panel-body-alt relative">
              <load-overlay bg="white-bg" :show="$root.loading" padding="30px 0"></load-overlay>
              <shop-review shop-slug="{{$shop->slug}}"></shop-review>
            </div>

    </div>

  @endif

</div>

@endsection
