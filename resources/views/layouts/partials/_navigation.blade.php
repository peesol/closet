<nav id="full-line">
  <div class="nav-container">
    <side-menu user-shop="{{ Auth::user()->shop->slug }}"></side-menu>
    <div class="main-logo"><a href="/"></a></div>
    <search-input></search-input>
    <button class="icon-search res-search-btn"></button>
    <div class="login-box">
      @if (Auth::guest())
          <li><a href="{{ route('login') }}">{{__('message.login')}}</a></li>
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
      <a href="{{ route('shops') }}">
        <span class="icon-refresh"></span>
        <font>{{ __('message.used') }}</font>
      </a>
    </div>
</div>
