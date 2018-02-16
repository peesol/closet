@if(!Auth::check())
<div class="product-show-panel">
  <div class="panel-body" id="full-line">
    <div class="alert-box info">
      <h3 class="no-margin">
        <span class="icon-notification"></span>
        {{__('auth.login_notice')}}<a class="link-text font-bold" href="{{ route('login')}}">&nbsp;{{__('message.login')}}</a>
        {{__('auth.login_notice2')}}<a class="link-text font-bold" href="{{ route('register')}}">&nbsp;{{__('message.register')}}</a>
      </h3>
    </div>
  </div>
</div>
@endif
