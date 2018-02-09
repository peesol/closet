<nav class="navbar fixed-nav-bar">
  <div class="nav-container">
    <side-menu></side-menu>
    <div class="main-logo"><a href="/"></a></div>

    <div class="login-box">
      @if (Auth::guest())
          <li><a href="{{ route('login') }}">{{__('message.login')}}</a></li>
          <li><a href="{{ route('register') }}">{{__('message.register')}}</a></li>
      @else

      <cart-icon></cart-icon>

      <user-dropdown
      user-name="{{ Auth::user()->name }}"
      logout-route="{{ route('logout') }}"
      user-shop="{{ Auth::user()->shop->slug }}"></user-dropdown>
      @endif
    </div>
  </div>
</nav>
<div class="second-nav">
    <div class="second-nav-cont">
        <div id="second-nav-link"><a href="{{ route('home') }}">{{__('message.home')}}</a></div>
        <div id="second-nav-link"><a href="{{ route('categoryMain') }}">{{__('message.category')}}</a></div>
        <div id="second-nav-link"><a href="{{ route('trending') }}">{{__('message.trending')}}</a></div>
        <div id="second-nav-link"><a href="{{ route('shops') }}">{{__('message.shops')}}</a></div>
    </div>
</div>
