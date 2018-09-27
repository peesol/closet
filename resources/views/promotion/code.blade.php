@extends('layouts.app')
@section('title')
{{__('message.discount_code')}}
@endsection
@section('content')

<div class="container">
  <div class="medium-panel">
    <div class="panel-heading">
      <label class="full-label heading">{{__('message.promotions_manage')}}</label>
    </div>
    <div class="tab-nav">
        <ul class="tab-nav-ul static">
            <button class="tab-nav-btn current">{{__('message.discount_code')}}</button>
            <button class="tab-nav-btn" onclick='document.location.href="{{route('promotionDiscount')}}"'>{{__('message.product_discount')}}</button>
        </ul>
    </div>
    <div class="panel-body">
      <div class="tab-content current relative" id="tab-1">
        <load-overlay bg="white-bg" :show="$root.loading" padding="30px 0"></load-overlay>
        <discount-code></discount-code>
      </div>
    </div>
  </div>
</div>

@endsection
