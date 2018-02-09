@extends('layouts.app')
@section('title')
{{__('message.discount_code')}}
@endsection
@section('content')

<div class="container">
  <div class="shop-panel">
    <div class="panel-heading"><h3 class="no-margin" style="font-weight: 600;">{{__('message.promotions_manage')}}</h3></div>
    <div class="tab-nav">
        <ul class="tab-nav-ul">
          <button class="tab-nav-btn" onclick='document.location.href="{{route('promotionCode')}}"'>{{__('message.discount_code')}}</button>
          <button class="tab-nav-btn current">{{__('message.product_discount')}}</button>
        </ul>
    </div>
    <div class="panel-body">
      <div class="alert-box warning">
        <span class="icon-warning"></span>&nbsp;{{__('message.product_discount_warn')}}
      </div>
      <product-discount points="{{$points->discount}}"></product-discount>
    </div>
  </div>
</div>

@endsection
