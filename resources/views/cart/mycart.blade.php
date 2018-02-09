@extends('layouts.app')

@section('title')
{{__('message.cart').' - '}}
@endsection

@section('content')

<div class="container">
  <div class="shop-panel">
    <div class="panel-heading">
      <h3 class="no-margin">{{__('message.cart')}}</h3>
    </div>
    <div class="cart-wrap panel-body">
      <cart user-id="{{ Auth::check() ? Auth::user()->id : 'null' }}" user-name="{{ Auth::check() ? Auth::user()->name : 'null' }}"></cart>
    </div>
  </div>
</div>

@endsection
