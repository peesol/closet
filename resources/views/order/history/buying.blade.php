@extends('layouts.app')

@section('title')
{{__('message.buying_history').' - '}}
@endsection

@section('content')

<div class="container">
  <div class="medium-panel">
    <div class="panel-heading">
      <label class="heading">{{ __('message.buying_history') }}</label>
    </div>
    <div class="panel-body">
      <order-history type="buying"></order-history>
    </div>
  </div>
</div>

@endsection
