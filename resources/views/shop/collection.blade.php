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
                          <button class="tab-nav-btn static" onclick='document.location.href="/{{$shop->slug}}/products"'><span class="icon-silhouette"></span><font>{{__('message.product')}}</font></button>
                          <button class="tab-nav-btn static current"><span class="icon-map"></span><font>{{__('message.collection')}}</font></button>
                          <button class="tab-nav-btn static" onclick='document.location.href="/{{$shop->slug}}/about"'><span class="icon-user"></span><font>{{__('message.about')}}</font></button>
                          <button class="tab-nav-btn static" onclick='document.location.href="/{{$shop->slug}}/reviews"'><span class="icon-star-full"></span><font>{{__('message.review')}}</font></button>
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
