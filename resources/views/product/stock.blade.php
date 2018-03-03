@extends('layouts.app')

@section('title')
{{__('message.stock_edit').' - '}}
@endsection

@section('content')

<div class="container">
  <div class="medium-panel">
    <product-stock></product-stock>
  </div>
</div>

@endsection
