@extends('layouts.app')

@section('content')

<div class="container">
  <div class="medium-panel">
      <div class="padding-15-top align-center">
        <label class="font-15em font-green">{{__('auth.register_success')}}</label>
      </div>
      <div class="panel-body align-center">
      <h3 class="no-margin font-grey">{{__('auth.verification_sent')}}</h3>
      <p class="font-red">*{{__('auth.verification_sent_notice')}}</p>
      <div class="padding-15-vertical">
        <a class="help-btn padding-10" href="{{ route('resendEmail') }}">{{ __('auth.verify_resend') }}</a>
      </div>
      <h3><a href="{{route('home')}}" class="link-text"><<< {{ __('error.404_home_route') }}</a></h3>
      </div>
  </div>
</div>

@endsection
