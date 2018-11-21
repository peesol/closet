@extends('layouts.app')

@section('content')

<div class="container">
            <div class="medium-panel transparent-bg">
              <div class="full-width full-banner banner margin-10-top">
                <banner-slick :banners="{{ json_encode($banners) }}"></banner-slick>
              </div>
            </div>
            @if(Auth::guest())
            <div class="medium-panel margin-10-top">
              <div class="panel-body">
                <p class="no-margin">{{__('message.home_signup')}}&nbsp;<a href="{{ route('register') }}" class="help-btn padding-5">{{__('message.home_signup_link')}}</a></p>
              </div>
            </div>
            <div class="medium-panel margin-10-top">
              <div class="panel-body">
                <p class="no-margin">{{__('ads.example')}}&nbsp;<a href="{{ route('homeExample') }}" class="help-btn padding-5">Click</a></p>
              </div>
            </div>
            <div class="medium-panel margin-10-top">
              <div class="panel-body">
                <h3 class="font-orange no-margin">{{ __('ads.title') }}</h3>
                <ul>
                  <li>{{ __('ads.1') }}</li>
                  <li>{{ __('ads.2') }}</li>
                  <li>{{ __('ads.3') }}</li>
                  <li>{{ __('ads.4') }}</li>
                  <li>{{ __('ads.5') }}</li>
                </ul>
              </div>
            </div>
            @endif
            <div class="medium-panel margin-10-top">
              <div class="panel-heading-alt">
                <label class="heading">{{__('message.trending_product')}}</label>
                <a href="/trending">{{__('message.read_more')}}</a>
              </div>
                <div class="products-carousel">
                  <vue-slick :products="{{ $products }}" path="/product/thumbnail/" slick-for="shop"></vue-slick>
                </div>
                <div class="panel-heading-alt">
                  <label class="heading">{{__('message.trending_shops')}}</label>
                </div>

                <div class="shops-list">
                  @foreach ($shops as $shop)
                    <div>
                      <img src="{{ $shop->getThumbnail() }}">
                      <a class="text-nowrap" href="/{{ $shop->slug }}">{{ $shop->name }}</a>
                    </div>
                  @endforeach
                </div>

            </div>

</div>

@endsection
