@extends('layouts.app')

@section('title')
{{__('message.cart')}}
@endsection
@section('css')
<link href="{{ asset('css/slick-theme.css') }}" rel="stylesheet">
<link href="{{ asset('css/slick.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script type="text/javascript" src="{{asset('js/slick.min.js')}}"></script>

@endsection
@section('content')

<div class="container">
  <div class="shop-panel">
    <div class="panel-heading">
      <h3 class="no-margin">My cart</h3>
    </div>
    <div class="cart-wrap panel-body">
      <cart user-id="{{ Auth::check() ? Auth::user()->id : 'null' }}" user-name="{{ Auth::check() ? Auth::user()->name : 'null' }}"></cart>
    </div>
  </div>
</div>
<script>
$('.product-showcase').slick({
    dots: true
});

window.addEventListener('load', function () {
    var comment = new Vue({
      el: '.cart-wrap',
    });
});
</script>

@endsection
