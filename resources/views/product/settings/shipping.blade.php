@extends('layouts.app')

@section('content')

<div class="container">
  <div class="large-panel">
    <div class="panel-heading">
      <h3 class="no-margin">{{__('message.shipping_edit')}}</h3>
    </div>
    <div class="panel-body">
      <li>{{__('message.shipping_edit_notice')}}</li>
      <shipping-edit></shipping-edit>
    </div>
  </div>
</div>

@endsection

@section('css')

@endsection

@section('scripts')
<script>
window.addEventListener('load', function () {
    var details = new Vue({
      el: '.panel-body'
    });
});
</script>
@endsection
