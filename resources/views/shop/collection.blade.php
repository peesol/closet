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
                          <button class="tab-nav-btn static" onclick='document.location.href="/{{$shop->slug}}/products"'><span class="icon-silhouette"></span><font>{{__('message.product')}}</font></button>
                          <button class="tab-nav-btn static current"><span class="icon-map"></span><font>{{__('message.collection')}}</font></button>
                          <button class="tab-nav-btn static" onclick='document.location.href="/{{$shop->slug}}/about"'><span class="icon-user"></span><font>{{__('message.about')}}</font></button>
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
