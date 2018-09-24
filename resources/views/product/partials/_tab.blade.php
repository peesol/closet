<div class="medium-panel">
    <div class="tab-nav">
        <div class="tab-nav-ul static">
            <button class="tab-nav-btn current" data-tab="#tab-1">{{__('message.details')}}</button>
            <button class="tab-nav-btn" data-tab="#tab-2">{{__('message.contact')}}</button>
            <button class="tab-nav-btn" v-on:click="$root.tab = 'comment'" data-tab="#tab-3">{{__('message.comment')}}</button>
        </div>
    </div>

        <div class="tab-content current" id="tab-1">
          @include('product.partials._description')
        </div>
        <div class="tab-content" id="tab-2">
          <contacts-show :contacts="{{ json_encode($contacts) }}"></contacts-show>
        </div>
        <div class="tab-content" id="tab-3">
          @if(!Auth::check())
          <div class="alert-box info">
            <label class="input-label full-label">
              <i class="fas fa-exclamation-circle"></i>
              {{__('auth.comment_notice')}}<a class="link-text font-bold" href="{{ route('login')}}">&nbsp;{{__('auth.login')}}</a>
            </label>
          </div>
          @endif
          <product-comment product-uid="{{ $product->uid }}"></product-comment>
        </div>
</div>
