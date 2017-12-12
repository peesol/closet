@extends('layouts.app')

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
      <h3 class="no-margin">{{__('message.selling_order')}}</h3>
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
