@extends('layouts.app')

@section('content')

<div class="container">
  <div class="medium-panel">
    <div class="panel-heading">
      <h3 class="no-margin">{{__('message.collection')}}</h3>
    </div>
    <div class="panel-body">
      <shop-collection shop-slug="{{Auth::user()->shop->slug}}" shop-user="{{Auth::id()}}"></shop-collection>
    </div>
  </div>
</div>

@endsection
