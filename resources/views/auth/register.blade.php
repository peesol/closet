@extends('layouts.app')
@section('title')
{{__('message.register').' - '}}
@endsection
@section('content')
<div class="container">
            <div class="login-panel">
                <div class="panel-heading"><h3 class="no-margin">{{__('message.register')}}</h3></div>
                <div class="panel-body">
                    <form role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="full-label">{{__('message.register_name')}}</label>
                                <input id="name" type="text" class="form-input {{ $errors->has('name') ? ' error-input' : '' }}" name="name" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                                @endif
                        </div>

                        <div class="form-group">
                          <label for="gender">{{__('message.gender')}}</label>
                          <input required type="radio" name="gender" value="men"><font>&nbsp;{{__('message.men')}}</font>
                          <input required type="radio" name="gender" value="women"><font>&nbsp;{{__('message.women')}}</font>
                        </div>

                        <div class="form-group{{ $errors->has('shop_name') ? ' has-error' : '' }}">
                            <label for="shop_name" class="full-label">{{__('message.register_shop')}}
                              <span class="link-text" data-balloon="{{__('message.shop_name_tip')}}" data-balloon-pos="right"><span class="icon-info"></span></span>
                            </label>
                                <input id="shop_name" type="text" class="form-input {{ $errors->has('shop_name') ? ' error-input' : '' }}" name="shop_name" required placeholder="{{__('message.shop_name_placeholder')}}">

                                @if ($errors->has('shop_name'))
                                    <span class="help-block"><strong>{{ $errors->first('shop_name') }}</strong></span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="full-label">{{__('message.email')}}</label>

                                <input id="email" type="email" class="form-input {{ $errors->has('email') ? ' error-input' : '' }}" name="email" required placeholder="example@gmail.com">

                                @if ($errors->has('email'))
                                    <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="full-label">{{ __('message.password')}}</label>
                                <input id="password" type="password" class="form-input {{ $errors->has('password') ? ' error-input' : '' }}" name="password" required placeholder="{{__('message.password_placeholder')}}">

                                @if ($errors->has('password'))
                                    <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                                @endif
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="full-label">{{__('message.confirm_password')}}</label>
                            <input id="password-confirm" type="password" class="form-input {{ $errors->has('password-confirm') ? ' error-input' : '' }}" name="password_confirmation" required>
                        </div>

                        <div class="form-group">
                            <label for="address" class="full-label">{{__('message.address')}}
                              <span class="link-text" data-balloon="{{__('message.address_tip')}}" data-balloon-pos="right"><span class="icon-info"></span></span>
                            </label>
                            <textarea id="address" class="description-input {{ $errors->has('address') ? ' error-input' : '' }}" style="height:150px;" name="address" rows="4" cols="80" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="full-label">{{__('message.phone')}}
                              <span class="link-text" data-balloon="{{__('message.address_tip')}}" data-balloon-pos="right"><span class="icon-info"></span></span>
                            </label>
                            <input id="phone" type="text" class="form-input {{ $errors->has('phone') ? ' error-input' : '' }}" name="phone" required>
                        </div>

                        <button type="submit" class="login-btn">{{__('message.register')}}</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/balloon-css/0.5.0/balloon.min.css">
@endsection
