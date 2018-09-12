<nav id="full-line">
  <div class="nav-container">
    <side-menu user-shop="{{ Auth::user() ? Auth::user()->shop->slug : null }}"></side-menu>
    <div class="align-center">
      <a href="/">
        <img class="main-logo" src="https://s3-ap-southeast-1.amazonaws.com/files.closet/etc/logo_orange.svg" alt="">
      </a>
    </div>
    <search-input></search-input>
    <button class="icon-search res-search-btn display-mobile"></button>
    <div class="login-box">
      @if (Auth::guest())
          <li><a href="{{ route('login') }}">{{__('auth.login')}}</a></li>
          <li><a href="{{ route('register') }}">{{__('message.register')}}</a></li>
      @else
      <user-nav
      user-name="{{ Auth::user()->name }}"
      logout-route="{{ route('logout') }}"
      user-shop="{{ Auth::user()->shop->slug }}"></user-nav>
      @endif
    </div>
  </div>
</nav>
<div class="second-nav">
    <div class="second-nav-cont">
      <a href="{{ route('home') }}">
        <span class="icon-home"></span>
        <font>{{ __('message.home') }}</font>
      </a>
      <a href="{{ route('categoryMain') }}">
        <span class="icon-category"></span>
        <font>{{ __('message.category') }}</font>
      </a>
      <a href="{{ route('trending') }}">
        <span class="icon-fire"></span>
        <font>{{ __('message.trending') }}</font>
      </a>
      <a href="{{ route('secondhand') }}">
        <span class="icon-refresh"></span>
        <font>{{ __('message.used') }}</font>
      </a>
    </div>
</div>
