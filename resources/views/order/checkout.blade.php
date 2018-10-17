@extends('layouts.app')

@section('title')
{{__('message.buying_order').' - '}}
@endsection

@section('content')

<div class="container">
  <div class="medium-panel">
    <div class="panel-heading">
      <label class="heading full-width">{{ __('message.order_checkout') }}</label><br>
      #{{ $order->uid }}
    </div>
    <div class="alert-box info">
      <i class="fas fa-exclamation-triangle"></i>&nbsp;{{ __('message.order_checkout_notice') }}&nbsp;<a href="{{ route('buyingOrder')}}">{{ __('message.buying_order') }}</a>
    </div>
    <div class="padding-15-horizontal" id="full-line">
      <p>
        {{ $order->title }}<br>
        {{ __('message.seller') }}&nbsp;{{ $order->reciever }}
      </p>
      <table class="c-table">
        <tr>
          <th>{{ __('message.products') }}</th>
        </tr>
        @foreach (json_decode($order->body) as $item)
          <tr>
            <td>
              {{$item->name}}&nbsp;{{$item->options->choice}}&nbsp;{{ __('message.price') }}&nbsp;{{number_format($item->price)}}&nbsp;&times;&nbsp;{{$item->qty}}
            </td>
          </tr>
        @endforeach
        <tr>
          <td>
            @foreach (json_decode($order->shipping) as $shipping)
            {{__('message.total')}} {{ $order->subtotal }} ฿
            @if($order->discount)
            ({{__('message.discount')}} {{$order->discount}})
            @endif
            <br>
            {{__('message.shipping_fee')}} {{ $shipping->free ? __('message.free_shipping') : $order->fee.' ฿' }}<br>
            {{__('message.shipping')}} {{ $shipping->method }} {{ __('message.shipping_time') . ' ' . $shipping->time . ' ' . __('message.days')}}<br>
            <small>{{ $shipping->multiply ? ' +' . $shipping->multiply_by . ' ฿ ' . __('message.shipping_multiply') : null }}</small><br>
            <strong class="font-green font-large">{{__('message.total_price')}} {{ $order->total }}&nbsp;฿</strong>
            @endforeach
          </td>
        </tr>
      </table>
      <p>
        {{__('message.address')}}<br>
        {{ $order->address }}
      </p>
    </div>
    <div class="">
      <div class="panel-heading">
        <label class="heading">{{ __('message.confirm_transaction') }}</label>
      </div>
      @foreach($accounts as $account)
      <div class="col-3-flex-res" id="full-line" style="padding:5px 15px">
        <div class="text-row">
          {{$account->provider_name}}&nbsp;
            @if ($account->type == 'PromptPay')
              <i class="font blue-bg">{{ __('message.promptpay') }}</i>
            @endif
        </div>
        <div class="text-row font-green">
          {{$account->number}}
        </div>
        <div class="text-row">
          {{$account->name}}
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>

@endsection
