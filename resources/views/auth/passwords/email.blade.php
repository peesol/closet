@extends('layouts.app')

@section('content')
<div class="container">
        <div class="small-panel">
                <div class="panel-heading"><label class="heading">{{__('auth.reset_password')}}</label></div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="form-label">{{__('auth.email')}}</label>

                                <input id="email" type="email" class="form-input" name="email" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="font-red">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    {{__('auth.email_password_reset')}}
                                </button>
                        </div>
                    </form>
                </div>
        </div>
</div>
@endsection
