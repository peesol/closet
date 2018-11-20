<nav id="full-line">
  <div class="nav-container">
    <side-menu user-shop="{{ Auth::user() ? Auth::user()->shop->slug : null }}"></side-menu>
    <div class="align-center">
      <a href="/">
        <img class="main-logo" src="https://s3-ap-southeast-1.amazonaws.com/files.closet/etc/logo_orange.svg" alt="">
      </a>
    </div>
    <search-input></search-input>
    <button class="fas fa-search res-search-btn mobile-only"></button>
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
        <span class="fas fa-home"></span>
        <font>{{ __('message.home') }}</font>
      </a>
      <a href="{{ route('categoryMain') }}">
        <span class="fas fa-th-large"></span>
        <font>{{ __('message.category') }}</font>
      </a>
      <a href="{{ route('trending') }}">
        <span class="fas fa-fire"></span>
        <font>{{ __('message.trending') }}</font>
      </a>
      {{-- <a href="{{ route('secondhand') }}">
        <span class="fas fa-redo-alt"></span>
        <font>{{ __('message.used') }}</font>
      </a> --}}
    </div>
</div>
