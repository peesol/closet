@extends('layouts.app')

@section('title')
{{__('message.cart').' - '}}
@endsection

@section('content')

<div class="container">
  <div class="medium-panel">
    <div class="panel-heading">
      <label class="full-label heading">{{__('message.cart')}}</label>
    </div>
    <div class="cart-wrap panel-body">
      <cart user-id="{{ Auth::check() ? Auth::user()->id : 'null' }}" user-name="{{ Auth::check() ? Auth::user()->name : 'null' }}"></cart>
    </div>
  </div>
</div>

@endsection
