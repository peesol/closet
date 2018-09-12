@extends('layouts.app')

@section('content')

<div class="container">
            <div class="medium-panel">
                <div class="panel-body align-center">
                <h2 class="font-green">{{__('auth.verification_finished')}}</h2>
                <button class="help-btn padding-10 width-120" onclick='document.location.href="{{url('/login')}}"'>{{__('auth.login')}}</button>
                </div>
            </div>
</div>

@endsection
