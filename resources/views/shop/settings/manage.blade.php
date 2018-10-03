@extends('layouts.app')
@section('title')
{{__('message.closet_edit').' - '}}
@endsection
@section('content')
<div class="container">
  <div class="small-panel">

        <div class="tab-nav">
            <div class="tab-nav-ul">
              <router-link class="tab-nav-btn" :class="{'current' : $route.name == 'contactEdit'}" to="/manage/contact">{{ __('message.contact')}}</router-link>
              <router-link class="tab-nav-btn" :class="{'current' : $route.name == 'showcaseEdit'}" to="/manage/showcase">{{ __('message.showcase')}}</router-link>
              <router-link class="tab-nav-btn" :class="{'current' : $route.name == 'accountEdit'}" to="/manage/account">{{ __('message.bank_account')}}</router-link>
            </div>
        </div>

          <div class="panel-body relative">
            <load-overlay bg="white-bg" :show="$root.loading" padding="40px 0"></load-overlay>
            <router-view></router-view>
            <div class="align-center" :class="{'not-display' : $route.name}">
              <h2 class="font-grey">{{ __('message.management_guide') }}</h2>
              <h2 class="font-grey">{{ __('message.management_guide2') }}</h2>
            </div>
          </div>

  </div>
</div>

@endsection
