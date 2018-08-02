@extends('layouts.app')

@section('title')
{{__('message.selling_order').' - '}}
@endsection

@section('content')

<div class="container">
  <div class="medium-panel">
    <div class="tab-nav">
        <ul class="tab-nav-ul">
            <button class="tab-nav-btn current">{{ __('message.selling_order')}}</button>
            <button class="tab-nav-btn" onclick='document.location.href="{{ url('/profile/order/buying') }}"'>{{ __('message.buying_order')}}</button>
        </ul>
    </div>
    <div class="msg-container panel-body">
      <div class="padding-15-vertical">
        <a href="/profile/order/selling/history" class="font-15em">{{ __('message.selling_history') }}>></a>
      </div>
      <order-selling></order-selling>
    </div>
  </div>
</div>

@endsection
