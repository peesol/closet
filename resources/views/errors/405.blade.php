@extends('errors.layout')
@section('contents')
  <h1 class="align-center"><i class="fa-exclamation-triangle fas font-red" style="font-size: 3em"></i><br>405</h1>
  <h2 class="align-center">{{ __('error.oops') }}</h2>
  <h3 class="align-center">{{ __('error.405_message') }}</h3>
@endsection
