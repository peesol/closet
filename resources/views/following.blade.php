@extends('layouts.app')
@section('title')
{{__('message.following').' - '}}
@endsection
@section('content')

<div class="container">
            <div class="large-panel">
            <div class="panel-heading" style="border-bottom: 1px solid #f2f2f2;"><p class="font-bold no-margin">{{__('message.following')}}</p></div>
            @foreach($followingShop as $shop)
                <div class="panel-heading">
                <a href="/{{ $shop->slug}}">
                   <img src="{{ $shop->getThumbnail() }}" alt="{{ $shop->thumbnail }}" style="float: left; width: 100px; border-radius: 50%;">
                </a>

                    <div class="shop-wrap">
                        <a class="shop-name" href="/{{ $shop->slug}}">{{ $shop->name }}</a><br>
                        <p class="shop-description">{{ $shop->description }}</p>
                    </div>
                        <div class="following-btn-wrap">
                            <follow-button shop-slug="{{ $shop->slug}}"></follow-button>
                        </div>
                </div>
            @endforeach

          </div>
</div>
<script>
    window.addEventListener('load', function () {
        var follow = new Vue({
          el: '.large-panel'
        });
    });
</script>
@endsection
