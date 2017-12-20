@extends('layouts.app')

@section('title')
{{__('message.selling_order').' - '}}
@endsection

@section('css')
<link href="{{ asset('css/slick-theme.css') }}" rel="stylesheet">
<link href="{{ asset('css/slick.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
@endsection
@section('content')

<div class="container">
  <div class="shop-panel">
    <div class="tab-nav">
        <ul class="tab-nav-ul">
            <button class="tab-nav-btn current">{{ __('message.selling_order')}}</button>
            <button class="tab-nav-btn" onclick='document.location.href="{{ url('/profile/order/buying') }}"'>{{ __('message.buying_order')}}</button>
        </ul>
    </div>
    <div class="msg-container panel-body">
      <order-selling></order-selling>
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
