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
    <order-view :data="{{ $order }}" :accounts="{{ $accounts }}"></order-view>
  </div>
</div>

@endsection
