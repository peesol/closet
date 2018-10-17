@extends('layouts.app')

@section('title')
{{__('message.cart').' - '}}
@endsection

@section('content')

<div class="container">
  <div class="medium-panel">
    <cart :user="{{ Auth::check() ? Auth::user() : 'null' }}"></cart>
  </div>
</div>

@endsection
