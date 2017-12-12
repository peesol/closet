<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
    <script>
window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
window.Closet = {
    url:'{{ config('app.url') }}',
    locale:'{{ App::getLocale() }}',
        user:{
            user: {{ Auth::check() ? Auth::user()->id : 'null' }},
            authenticated: {{ Auth::check() ? 'true':'false'}}
        }
    };
    </script>

</head>
<body>
    <div class="overlay"></div>
    <div id="app">
@include('layouts.partials._navigation')

<div class="container">
            <div class="login-panel">
                <div class="panel-heading"><h3 class="no-margin"><span class="icon-lock" style="color:#6c6c6c;"></span>{{__('message.login')}}</h3></div>
                <div class="panel-body">
                   <form role="form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="form-label">{{__('message.email')}}</label>

                                <input id="email" type="email" class="form-input {{ $errors->has('email') ? ' error-input' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="form-label">{{__('message.password')}}</label>

                                <input id="password" type="password" class="form-input" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>

                            <div class="submit-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>{{__('message.remember')}}
                                    </label>
                                </div>

                                <button type="submit" class="login-btn">
                                    {{__('message.login')}}
                                </button>

                                <a class="forgot-password" href="{{ route('password.request') }}">
                                    {{__('message.forgot_password')}}
                                </a>
                            </div>
                   </form>
            </div>
        </div>
    </div>
</div>

    </div>
</body>
</html>
