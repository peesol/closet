@extends('layouts.app')

@section('title')
{{'campaign - '}}
@endsection

@section('content')

<div class="container">
  <div class="medium-panel">
    <div class="panel-heading">
      <label class="full-label heading">{{__('message.promotions_manage')}}</label>
    </div>
    <div class="tab-nav">
        <ul class="tab-nav-ul static">
            <button class="tab-nav-btn" onclick='document.location.href="{{route('promotionCode')}}"'>{{__('message.discount_code')}}</button>
            <button class="tab-nav-btn" onclick='document.location.href="{{route('promotionDiscount')}}"'>{{__('message.product_discount')}}</button>
            <button class="tab-nav-btn current" >{{__('message.campaign')}}</button>
        </ul>
    </div>
    <div class="panel-body relative">
      <load-overlay bg="white-bg" :show="$root.loading" padding="30px 0"></load-overlay>
      <product-campaign :campaigns="{{ $campaigns }}" :points="{{ $points['campaign'] }}"></product-campaign>
    </div>
  </div>

</div>

@endsection
