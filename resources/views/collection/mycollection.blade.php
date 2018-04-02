@extends('layouts.app')

@section('content')

<div class="container">
  <div class="medium-panel">
    <div class="panel-heading">
      <label class="heading">{{__('message.collection')}}</label>
    </div>

    <shop-collection shop-slug="{{Auth::user()->shop->slug}}" shop-user="{{Auth::id()}}"></shop-collection>

  </div>
</div>

@endsection
