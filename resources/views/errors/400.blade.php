@extends('errors.layout')
@section('contents')
  <h1 class="align-center"><i class="fa-exclamation-triangle fas font-red" style="font-size: 3em"></i><br>400</h1>
  <h2 class="align-center">{{ __('error.oops') }}</h2>
  <h3 class="align-center">{{ __('error.400_message') }}</h3>
  <h3 class="align-center">{{ __('error.400_message2') }}</h3>
@endsection
