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
            </div>
        </div>

        {{-- <div class="tab-content current" id="tab-1">
          <shop-edit shop-name="{{$shop->name}}"
            shop-description="{{$shop->description}}"
            profile-thumbnailnail="{{$shop->getThumbnail()}}"
            shop-cover="{{$shop->getCover()}}"
            shop-slug="{{$shop->slug}}"
            user-address="{{$shop->user->address}}"
            user-phone="{{$shop->user->phone}}"></shop-edit>
          </div> --}}
          <div class="panel-body">
            <router-view></router-view>
          </div>


  </div>
</div>

@endsection
