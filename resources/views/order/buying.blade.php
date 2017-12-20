@extends('layouts.app')

@section('title')
{{__('message.buying_order').' - '}}
@endsection

@section('css')
<link href="{{ asset('css/slick-theme.css') }}" rel="stylesheet">
<link href="{{ asset('css/slick.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.0.9/cleave.min.js"></script>

@endsection
@section('content')

<div class="container">
  <div class="shop-panel">
    <div class="tab-nav">
        <ul class="tab-nav-ul">
            <button class="tab-nav-btn" onclick='document.location.href="{{ url('/profile/order/selling') }}"'>{{ __('message.selling_order')}}</button>
            <button class="tab-nav-btn current">{{ __('message.buying_order')}}</button>
        </ul>
    </div>
    <div class="msg-container panel-body">
      <order-buying user-name="{{Auth::user()->name}}" user-address="{{Auth::user()->address}}" user-phone="{{Auth::user()->phone}}"></order-buying>
    </div>
  </div>
</div>
<script>
window.addEventListener('load', function () {
    var list = new Vue({
      el: '.msg-container',
    });
});
</script>

@endsection
