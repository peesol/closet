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
                          <button class="tab-nav-btn current"><i class="fas fa-map"></i><font>{{__('message.collection')}}</font></button>
                          <button class="tab-nav-btn" onclick='document.location.href="/{{$shop->slug}}/about"'><i class="fas fa-user"></i><font>{{__('message.about')}}</font></button>
                          <button class="tab-nav-btn" onclick='document.location.href="/{{$shop->slug}}/reviews"'><i class="fas fa-star"></i><font>{{__('message.review')}}</font></button>
                        </ul>
                    </div>
        <div class="panel-heading-alt">
          <label class="full-label heading">{{__('message.collection')}}</label>
        </div>

            <shop-collection web-url="{{config('app.url')}}" shop-slug="{{ $shop->slug }}" shop-user="{{ $shop->user_id }}"></shop-collection>

            </div>
@endif

</div>

@endsection
