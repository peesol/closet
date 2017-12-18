@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
            <div class="login-panel">
                <div class="panel-heading"><h3 class="no-margin">{{__('message.success')}}</h3></div>
                <div class="panel-body">
                <p>{{__('message.verification_sent')}}</p>
                </div>
            </div>
    </div>
</div>

@endsection
