@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
            <div class="medium-panel">
                <div class="panel-heading"><label class="heading">{{__('message.success')}}</label></div>
                <div class="panel-body">
                <p>{{__('message.verification_sent')}}</p>
                <p class="font-red">{{__('message.verification_sent_notice')}}&nbsp;<a class="link-text" href="{{ route('resendEmail') }}">Click</a></p>
                </div>
            </div>
    </div>
</div>

@endsection
