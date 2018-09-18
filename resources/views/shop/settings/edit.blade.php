@extends('layouts.app')
@section('title')
{{__('message.closet_edit')}}
@endsection
@section('content')
<div class="container">
  <div class="small-panel">

        <div class="tab-nav">
            <div class="tab-nav-ul">
                <router-link class="tab-nav-btn" :class="{'current' : $route.name == 'generalEdit'}" to="/{{$shop->slug}}/edit/general">{{ __('message.general')}}</router-link>
                <router-link class="tab-nav-btn" :class="{'current' : $route.name == 'contactEdit'}" to="/{{$shop->slug}}/edit/contact">{{ __('message.contact')}}</router-link>
                <router-link class="tab-nav-btn" :class="{'current' : $route.name == 'showcaseEdit'}" to="/{{$shop->slug}}/edit/showcase">{{ __('message.showcase')}}</router-link>
                <router-link class="tab-nav-btn" :class="{'current' : $route.name == 'accountEdit'}" to="/{{$shop->slug}}/edit/account">{{ __('message.bank_account')}}</router-link>
                <router-link class="tab-nav-btn" :class="{'current' : $route.name == 'notificationSettings'}" to="/{{$shop->slug}}/edit/notification">{{ __('user.notification.title')}}</router-link>
            </div>
        </div>

          <div class="panel-body">
            <router-view shop-name="{{$shop->name}}"
              shop-description="{{$shop->description}}"
              shop-thumbnail="{{$shop->getThumbnail()}}"
              shop-cover="{{$shop->getCover()}}"
              shop-slug="{{$shop->slug}}"
              user-address="{{$shop->user->address}}"
              user-phone="{{$shop->user->phone}}"></router-view>
          </div>

  </div>
</div>

@endsection
