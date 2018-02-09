@extends('layouts.app')

@section('title')
{{__('message.notice').' - '}}
@endsection

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
      <cant-sell shop-slug="{{$shop->slug}}"></cant-sell>
    </div>
  </div>

</div>

@endsection
