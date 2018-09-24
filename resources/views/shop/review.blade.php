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
                  <button class="tab-nav-btn" onclick='document.location.href="/{{$shop->slug}}/products"'><i class="fas fa-shopping-bag"></i><font>{{__('message.product')}}</font></button>
                  <button class="tab-nav-btn" onclick='document.location.href="/{{$shop->slug}}/collection"'><i class="fas fa-map"></i><font>{{__('message.collection')}}</font></button>
                  <button class="tab-nav-btn" onclick='document.location.href="/{{$shop->slug}}/about"'><i class="fas fa-user"></i><font>{{__('message.about')}}</font></button>
                  <button class="tab-nav-btn current"><i class="fas fa-star"></i><font>{{__('message.review')}}</font></button>
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
