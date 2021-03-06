@extends('layouts.app')

@section('content')

<div class="container">
            <div class="medium-panel transparent-bg">
              <div class="full-width full-banner">
                <banner-slick :banners="{{ $banners }}"></banner-slick>
              </div>
            </div>
            @if(Auth::guest())
            <div class="medium-panel margin-10-top">
              <div class="panel-body">
                <p class="no-margin">{{__('message.home_signup')}}&nbsp;<a href="{{ route('register') }}" class="link-text">{{__('message.home_signup_link')}}</a></p>
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
