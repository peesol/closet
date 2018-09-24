@extends('layouts.app')
@section('title')
{{__('auth.login').' - '}}
@endsection
@section('content')
<div class="container">
            <div class="small-panel">
                <div class="panel-heading"><label class="heading"><i class="fas fa-lock"></i>{{__('auth.login')}}</label></div>
                <div class="panel-body">
                   <form role="form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="input-label full-label">{{__('auth.email')}}</label>

                                <input id="email" type="email" class="form-input {{ $errors->has('email') ? ' error-input' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="span-error">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="input-label full-label">{{__('auth.password')}}</label>

                                <input id="password" type="password" class="form-input" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="span-error">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>


                        <div class="checkbox padding-10">
                            <label class="full-label">
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <font class="font-light">{{__('auth.remember')}}</font>
                            </label>
                        </div>
                        <div class="align-center">
                          <button type="submit" class="orange-btn normal-sq width-120">{{__('auth.login')}}</button><br>
                          <p class="no-margin padding-15-top"><a class="forgot-password" href="{{ route('password.request') }}">{{__('auth.forgot_password')}}</a></p>
                        </div>

                   </form>
            </div>
            <div id="full-line"></div>
            <div class="panel-body">
              <p>{{__('auth.register')}}<a class="link-text" href="{{ route('register')}}">{{__('message.register')}}</a></p>
              <p>{{__('auth.verify')}}<a class="link-text" href="{{ route('resendEmail')}}">{{__('auth.resend')}}</a></p>
            </div>
        </div>
    </div>
@endsection
