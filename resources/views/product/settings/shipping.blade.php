@extends('layouts.app')

@section('title')
{{__('message.shipping_edit').' - '}}
@endsection

@section('content')

<div class="container">
  <div class="large-panel">
    <div class="panel-heading">
      <label class="full-label heading">{{__('message.shipping_edit')}}</label>
    </div>
    <div class="panel-body">
      <div class="alert-box info">
        <label class="full-label input-label"><span class="icon-notification"></span>&nbsp;{{__('message.shipping_edit_notice')}}</label>
      </div>
      <shipping-edit shop-slug="{{$shop->slug}}"></shipping-edit>
    </div>
  </div>
</div>

@endsection
