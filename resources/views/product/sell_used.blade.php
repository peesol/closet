@extends('layouts.app')

@section('title')
{{__('message.sell').' - '}}
@endsection

@section('content')

<div class="container">
  <div class="small-panel">

    <div class="tab-nav">
      <ul class="tab-nav-ul static">
        <button class="tab-nav-btn" onclick='document.location.href="/sell/new"'>{{__('message.new')}}</button>
        <button class="tab-nav-btn current">{{__('message.used')}}</button>
      </ul>
    </div>

    <div class="padding-30-horizontal">
      <used-sell></used-sell>
    </div>

  </div>
</div>

@endsection
