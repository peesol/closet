@extends('layouts.app')
@section('title')
{{__('message.register').' - '}}
@endsection
@section('content')
<div class="container">
            <div class="small-panel">
                <div class="panel-heading"><label class="heading">{{__('message.register')}}</label></div>
                <div class="panel-body">
                    <form role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="full-label">{{__('message.register_name')}}</label>
                                <input id="name" type="text" class="form-input {{ $errors->has('name') ? ' error-input' : '' }}" name="name" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="span-error">{{ $errors->first('name') }}</span>
                                @endif
                        </div>

                        <div class="form-group">
                          <label for="gender">{{__('message.gender')}}</label>
                          <input required type="radio" name="gender" value="men"><font>&nbsp;{{__('message.men')}}</font>
                          <input required type="radio" name="gender" value="women"><font>&nbsp;{{__('message.women')}}</font>
                          <input required type="radio" name="gender" value="etc"><font>&nbsp;{{__('message.etc')}}</font>
                        </div>

                        <div class="display-hidden">
                          <label for="profile_type">{{__('message.profile_type')}}</label>
                          <select class="select-input" name="profile_type">
                            <option value="1">{{__('message.shop')}}</option>
                          </select>
                        </div>

                        <div class="form-group{{ $errors->has('shop_name') ? ' has-error' : '' }}">
                            <label for="shop_name" class="full-label">{{__('message.register_shop')}}
                              <span class="link-text" data-balloon="{{__('message.shop_name_tip')}}" data-balloon-pos="right"><span class="icon-info"></span></span>
                            </label>
                                <input id="shop_name" type="text" class="form-input {{ $errors->has('shop_name') ? ' error-input' : '' }}" name="shop_name" required placeholder="{{__('message.shop_name_placeholder')}}">

                                @if ($errors->has('shop_name'))
                                    <span class="span-error">{{ $errors->first('shop_name') }}</span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="full-label">{{__('message.email')}}</label>

                                <input id="email" type="email" class="form-input {{ $errors->has('email') ? ' error-input' : '' }}" name="email" required placeholder="example@gmail.com">

                                @if ($errors->has('email'))
                                    <span class="span-error">{{ $errors->first('email') }}</span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="full-label">{{ __('message.password')}}</label>
                                <input id="password" type="password" class="form-input {{ $errors->has('password') ? ' error-input' : '' }}" name="password" required placeholder="{{__('message.password_placeholder')}}">

                                @if ($errors->has('password'))
                                    <span class="span-error">{{ $errors->first('password') }}</span>
                                @endif
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="full-label">{{__('message.confirm_password')}}</label>
                            <input id="password-confirm" type="password" class="form-input {{ $errors->has('password-confirm') ? ' error-input' : '' }}" name="password_confirmation" required>
                        </div>
                        <div class="alert-box info margin-15-vertical">
                          <p class="no-margin">{{__('message.address_tip')}}</p>
                        </div>
                        <div class="form-group">
                            <label for="address" class="full-label">{{__('message.address')}}</label>
                            <textarea id="address" class="comment-input {{ $errors->has('address') ? ' error-input' : '' }}" name="address" rows="4" cols="80" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="full-label">{{__('message.phone')}}</label>
                            <input id="phone" type="text" class="form-input {{ $errors->has('phone') ? ' error-input' : '' }}" name="phone" required>
                        </div>

                        <div class="padding-15-top align-right">
                          <button type="submit" class="orange-btn normal-sq">{{__('message.register')}}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
