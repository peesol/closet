@extends('layouts.app')

@section('title')
{{__('message.notice').' - '}}
@endsection

@section('content')

<div class="container">
    @if (!$shop->account->count())
      <div class="medium-panel margin-20-bottom">
        <div class="panel-body">
          <h3 class="font-red">{{__('message.cant_sell_account')}}</h3>
          <p>{{__('message.cant_sell_warn')}}</p>
          <p>{{__('message.cant_sell_account_guide')}}</p>
        </div>
      </div>

      <div class="small-panel margin-20-bottom">
        <cant-sell shop-slug="{{$shop->slug}}"></cant-sell>
      </div>
    @endif

    @if ($shop->shipping == null)
      <div class="medium-panel margin-20-bottom panel-body">
        <div>
          <h3 class="font-red">{{__('message.cant_sell_shipping')}}</h3>
          <p>{{__('message.cant_sell_warn')}}</p>
          <p>{{__('message.cant_sell_shipping_guide')}}</p>
        </div>
      </div>
      <div class="small-panel">
        <shipping-edit :shop-shipping="[]"></shipping-edit>
      </div>
    @endif



</div>

@endsection
