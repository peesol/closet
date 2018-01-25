@extends('layouts.app')

@section('content')

<div class="container">
  <div class="shop-panel">
    <div class="panel-heading">
      <h3 class="no-margin">{{__('message.collection')}}</h3>
    </div>
    <div class="panel-body">
      <shop-collection shop-slug="{{Auth::user()->shop->slug}}" shop-user="{{Auth::id()}}"></shop-collection>
    </div>
  </div>
</div>

<script>
window.addEventListener('load', function () {
    var follow = new Vue({
      el: '.container'
    });
});
</script>
@endsection
