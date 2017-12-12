@extends('layouts.app')

@section('content')
<div class="container">
            <div class="login-panel">
                <div class="panel-heading"><h3 class="no-margin">{{__('message.register')}}</h3></div>
                <div class="panel-body">
                    <form role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="form-label">{{__('message.register_name')}}</label>
                                <input id="name" type="text" class="form-input {{ $errors->has('email') ? ' error-input' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('shop_name') ? ' has-error' : '' }}">
                            <label for="shop_name" class="form-label">{{__('message.register_shop')}}</label>
                                <input id="shop_name" type="text" class="form-input {{ $errors->has('email') ? ' error-input' : '' }}" name="shop_name" value="{{ old('shop_name') }}" required autofocus>

                                @if ($errors->has('shop_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('shop_name') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="form-label">{{__('message.email')}}</label>

                                <input id="email" type="email" class="form-input {{ $errors->has('email') ? ' error-input' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="form-label">{{__('message.password')}}</label>
                                <input id="password" type="password" class="form-input {{ $errors->has('email') ? ' error-input' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="form-label">{{__('message.confirm_password')}}</label>

                                <input id="password-confirm" type="password" class="form-input {{ $errors->has('email') ? ' error-input' : '' }}" name="password_confirmation" required>
                        </div>

                                <button type="submit" class="login-btn">
                                    {{__('message.register')}}
                                </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
