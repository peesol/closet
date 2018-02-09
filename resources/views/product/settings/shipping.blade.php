@extends('layouts.app')

@section('title')
{{__('message.shipping_edit').' - '}}
@endsection

@section('content')

<div class="container">
  <div class="large-panel">
    <div class="panel-heading">
      <h3 class="no-margin">{{__('message.shipping_edit')}}</h3>
    </div>
    <div class="panel-body">
      <li>{{__('message.shipping_edit_notice')}}</li>
      <shipping-edit></shipping-edit>
    </div>
  </div>
</div>

@endsection
