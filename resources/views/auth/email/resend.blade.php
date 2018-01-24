@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="login-panel">
                <div class="panel-heading"><h3 class="no-margin">{{__('auth.resend')}}</h3></div>
                <div class="panel-body">

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('resendEmailPost') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                          <label for="email" class="form-label">{{__('message.email')}}</label>
                          <input id="email" type="email" class="form-input" name="email" required>
                          @if(!empty($message))
                          <span class="red-font"><strong>{{ $message }}</strong></span>
                          @endif
                        </div>

                        <div class="form-group">
                          <button type="submit" class="btn btn-primary">{{__('auth.resend')}}</button>
                        </div>
                    </form>
                </div>
        </div>
    </div>
</div>
@endsection
