@extends('layouts.app')

@section('title')
{{__('message.notice').' - '}}
@endsection

@section('content')

<div class="container">
  <div class="medium-panel">
    <div class="panel-body">
      <h4 class="font-red">{{__('message.cant_sell')}}</h4>
      <p>{{__('message.cant_sell_warn')}}</p>
      <p>{{__('message.cant_sell_guide')}}</p>
    </div>
  </div>

  <div class="small-panel">
    <div class="cant-sell">
      <cant-sell shop-slug="{{$shop->slug}}"></cant-sell>
    </div>
  </div>

</div>

@endsection
