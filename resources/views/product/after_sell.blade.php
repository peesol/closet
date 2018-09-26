@extends('layouts.app')

@section('title')
{{__('message.sell').' - '}}
@endsection

@section('content')

<div class="container">
  <div class="medium-panel">
    <div class="color-heading">
      {{__('message.pls_read')}}&nbsp;!!!
    </div>
    <div class="panel-body">
      <h2 class="font-green no-margin">{{__('message.after_sell_heading')}}</h2>
      <p class="font-large">{{__('message.after_sell_notice')}}&nbsp;<a href="{{ config('app.url') }}/profile/myproduct/stock">{{__('message.after_sell_link')}}</a></p>
      <p class="font-red font-large">{{__('message.after_sell_notice_2')}}</p>
      <p>*{{__('message.after_sell_notice_3')}}</p>
      <a class="font-15em" href="/sell/new"><<&nbsp;{{__('message.after_sell_back')}}</a><br>
      <a class="font-15em" href="/"><<&nbsp;{{__('message.back_home')}}</a>
    </div>
  </div>

  <div class="small-panel">

  </div>

</div>

@endsection
