@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
            <div class="medium-panel">
                <div class="panel-heading"><label class="heading">{{__('message.success')}}</label></div>
                <div class="panel-body">
                <h3 class="no-margin font-grey">{{__('message.verification_sent')}}</h3>
                <p class="font-red">*{{__('message.verification_sent_notice')}}&nbsp;<a class="link-text" href="{{ route('resendEmail') }}">Click</a></p>
                <h3 class="no-margin"><a href="{{route('home')}}" class="link-text"><<< {{ __('error.404_home_route') }}</a></h3>
                </div>
            </div>
    </div>
</div>

@endsection
