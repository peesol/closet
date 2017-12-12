@extends('layouts.app')

@section('content')
<div class="container">
  <div class="shop-panel" style="border-radius: 5px; margin-bottom: 20px;">
    <div class="panel-body">
      <h4 class="red-font">{{__('message.cant_sell')}}</h4>
      <p>{{__('message.cant_sell_warn')}}</p>
      <p>{{__('message.cant_sell_guide')}}</p>
    </div>
  </div>


  <div class="listing-panel">
    <div class="cant-sell" style="padding: 35px 35px;">
      <cant-sell></cant-sell>
    </div>
  </div>

</div>
<script>
    window.addEventListener('load', function () {
        var edit = new Vue({
          el: '.cant-sell',
          data: {
            shopSlug: '{{$shop->slug}}',
          }
        });
    });
</script>
@endsection
