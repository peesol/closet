@extends('layouts.app')
@section('title')
{{$shop->name}}
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
                            <button type="submit" class="product-nav-btn" onclick='document.location.href="/{{$shop->slug}}/collection"'>{{__('message.collection')}}</button>
                            <button type="submit" class="product-nav-btn-active">{{__('message.about')}}</button>
                        </ul>
                    </div>
            <div style="padding: 15px 45px;"><h3 class="no-margin">{{__('message.about')}}</h3></div>
            <div style="padding: 15px 45px;">
                @if($shop->description !== null)
                    <h4 class="no-margin">{{__('message.description')}}</h4>
                    <div class="about-description">

                    <p>{!! nl2br(e($shop->description)) !!}</p>
                    </div>
                @else
                    {{__('message.no_description')}}
                @endif

                @if($shop->contact->count())
                <h3>{{__('message.contact')}}</h3>
                <div class="">
                    @foreach($shop->contact as $contact)
                      @if($contact->link !== null)
                        <p>
                          <a style="font-weight: 600;" class="link-text" href="{{$contact->type}}"><span class="icon-{{$contact->type}}" style="font-size:30px; color:#6c6c6c;"></span>&nbsp;{{ $contact->body }}</a>
                        </p>
                      @else
                        <p><span class="icon-{{$contact->type}}" style="font-size: 30px; color:#6c6c6c;"></span>&nbsp;{{ $contact->body }}</p>
                      @endif
                    @endforeach
                </div>
                @endif

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
