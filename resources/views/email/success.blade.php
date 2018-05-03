@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
            <div class="medium-panel">
                <div class="panel-heading"><label class="heading">{{__('message.success')}}</label></div>
                <div class="panel-body">
                {{__('message.verification_finished')}} <a class="link-text" href="{{url('/login')}}">{{__('message.login')}}</a>
                </div>
            </div>
    </div>
</div>

@endsection
