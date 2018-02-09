@extends('layouts.app')

@section('title')
{{__('message.selling_order').' - '}}
@endsection

@section('content')

<div class="container">
  <div class="shop-panel">
    <div class="tab-nav">
        <ul class="tab-nav-ul">
            <button class="tab-nav-btn current">{{ __('message.selling_order')}}</button>
            <button class="tab-nav-btn" onclick='document.location.href="{{ url('/profile/order/buying') }}"'>{{ __('message.buying_order')}}</button>
        </ul>
    </div>
    <div class="msg-container panel-body">
      <order-selling></order-selling>
    </div>
  </div>
</div>

@endsection
