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
                            <button type="submit" class="product-nav-btn" onclick='document.location.href="/{{$shop->slug}}/products"'>{{__('message.product')}}</button>
                            <button type="submit" class="product-nav-btn-active">{{__('message.collection')}}</button>
                            <button type="submit" class="product-nav-btn" onclick='document.location.href="/{{$shop->slug}}/about"'>{{__('message.about')}}</button>
                        </ul>
                    </div>
            <div style="padding: 15px 45px;"><h3 class="no-margin">{{__('message.collection')}}</h3></div>

        <div class="panel-body">
            <shop-collection web-url="{{config('app.url')}}" shop-slug="{{ $shop->slug }}" shop-user="{{ $shop->user_id }}"></shop-collection>
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
        var collection = new Vue({
          el: '.panel-body',
        });
    });
</script>
@endsection
