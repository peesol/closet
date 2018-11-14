<div class="cover-wrap">

@if(Auth::check() && Auth::user()->id === $shop->user_id)
  <a href="/settings/profile">
    <button class="align-top-right flat-btn icon-bg">
      <i class="fas fa-pen"></i>
    </button>
  </a>
@endif
  <img src="{{ $shop->getCover() }}">
@if(Auth::check() && Auth::user()->id !== $shop->user_id)
  <button class="align-top-right orange-btn" onclick='document.location.href="{{ route('shopReportView', ['shop' => $shop->slug]) }}"'>{{ __('message.report_seller') }}</button>
@endif
</div>

<div class="profile-header-wrap" id="full-line">
  <div class="profile-info-wrap panel-body">

    <div class="profile-thumbnail">
      <img class="" src="{{ $shop->getThumbnail() }}" alt="{{ $shop->thumbnail }}">
    </div>

    <div class="profile-header-row flex">
      <label class="profile-name">{{ $shop->name }}
        @if ( $shop->shop_type === 2)
          <i class="fas fa-check verified-profile"></i>
        @endif
      </label>
    </div>

      <shop-stats shop-slug="{{ $shop->slug}}"></shop-stats>

  </div>

  <div class="profile-vote panel-body">
    @if (Auth::id() !== $shop->id)
      <div class="profile-header-row">
        <follow-button shop-slug="{{ $shop->slug}}"></follow-button>
      </div>
    @endif
    <div class="profile-header-row">
      <shop-rating shop-slug="{{ $shop->slug }}"></shop-rating>
    </div>

  </div>
</div>
