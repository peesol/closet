@extends('layouts.app')
@section('title')

@endsection
@section('content')

<div class="container">
  <div class="medium-panel">
    <div class="panel-heading"><h3 class="no-margin" style="font-weight: 600;">{{__('message.promotions_manage')}}</h3></div>

    <div class="panel-body">
      <h3 class="no-margin"><a class="link-text grey font-bold" href="{{route('promotionCode')}}">{{__('message.discount_code')}}</a></h3>
      <ul>
        <li>{{__('message.discount_code_info1')}}<font class="red-font">{{__('message.entire_order')}}</font>{{__('message.discount_code_info1_end')}}</li>
        <li><p class="no-margin">{{__('message.discount_code_info2')}}</p></li>
      </ul>
    </div>
    <div id="full-line"></div>

    <div class="panel-body">
      <h3 class="no-margin"><a class="link-text grey font-bold" href="{{route('promotionDiscount')}}">{{__('message.product_discount')}}</a>
        &nbsp;<font class="{{$points->discount ? 'green-font' : 'red-font'}}">{{__('message.promotions_points')}}&nbsp;:&nbsp;{{$points->discount}}</font></h3>
      <h4 class="no-margin"></h4>
      <ul>
        <li>{{__('message.product_discount_info1')}}</li>
        <li><p class="no-margin">{{__('message.product_discount_info3')}}</p></li>
        <li><p class="no-margin">{{__('message.product_discount_info2')}}</p></li>
        <li><p class="no-margin red-font">{{__('message.product_discount_info2_end')}}</p></li>
        <li><p class="no-margin red-font">{{__('message.product_discount_info4')}}</p></li>
      </ul>
    </div>
    <div id="full-line"></div>
  </div>

</div>
@endsection
