@extends('layouts.app')
@section('title')

@endsection
@section('content')

<div class="container">
  <div class="shop-panel">
    <div class="panel-heading"><h3 class="no-margin" style="font-weight: 600;">{{__('message.promotions_manage')}}</h3></div>
    <div class="panel-body">
      <discount-code></discount-code>
      <product-discount></product-discount>
      <flash-sale></flash-sale>
    </div>
  </div>
</div>
<script>
window.addEventListener('load', function () {
    var promotion = new Vue({
      el: '.panel-body',
      data: {
        url: window.Closet.url
      }
    });
});
</script>
@endsection
@section('js')

@endsection
