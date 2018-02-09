@extends('layouts.app')
@section('title')

@endsection
@section('content')

<div class="container">
  <div class="shop-panel">
    <div class="panel-heading"><h3 class="no-margin" style="font-weight: 600;">{{__('message.promotions_manage')}}</h3></div>
    <div class="tab-nav">
        <ul class="tab-nav-ul">
            <button class="tab-nav-btn current">{{__('message.discount_code')}}</button>
            <button class="tab-nav-btn" onclick='document.location.href="{{route('promotionDiscount')}}"'>{{__('message.product_discount')}}</button>
        </ul>
    </div>
    <div class="panel-body">
      <div class="tab-content current" id="tab-1">
        <discount-code></discount-code>
      </div>
    </div>
  </div>
</div>

@endsection
