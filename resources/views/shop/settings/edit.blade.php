@extends('layouts.app')
@section('title')
{{__('message.closet_edit').' - '}}
@endsection
@section('content')
<div class="container">
  <div class="small-panel">

        <div class="tab-nav">
            <div class="tab-nav-ul">
                <router-link class="tab-nav-btn" :class="{'current' : $route.name == 'profileEdit'}" to="/settings/profile">{{ __('message.general')}}</router-link>
                <router-link class="tab-nav-btn" :class="{'current' : $route.name == 'notificationSettings'}" to="/settings/notification">{{ __('user.notification.title')}}</router-link>
            </div>
        </div>

          <div class="panel-body relative">
            <load-overlay bg="white-bg" :show="$root.loading" padding="40px 0"></load-overlay>
            <router-view shop-id="{{ Auth::id() }}"></router-view>
          </div>

  </div>
</div>

@endsection
