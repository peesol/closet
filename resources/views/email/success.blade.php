@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
            <div class="login-panel">
                <div class="panel-heading"><h3 class="no-margin">Success</h3></div>
                <div class="panel-body">
                Your Email is successfully verified. Click here to <a class="link-text" href="{{url('/login')}}">login</a>
                </div>
            </div>
    </div>
</div>

@endsection
