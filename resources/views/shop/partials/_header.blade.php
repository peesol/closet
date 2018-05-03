<div class="cover-wrap">

@if(Auth::check() && Auth::user()->id === $shop->user_id)
  <a href="/{{$shop->slug}}/edit/general">
    <button class="align-top-right icon-cog edit-btn round-btn"></button>
  </a>
@endif

  <img src="{{ $shop->getCover() }}">
</div>

<div class="profile-header-wrap" id="full-line">
  <div class="profile-info-wrap panel-body">

    <div class="profile-thumbnail">
      <img class="" src="{{ $shop->getThumbnail() }}" alt="{{ $shop->thumbnail }}">
    </div>

    <div class="profile-header-row flex">
      <label class="profile-name">{{ $shop->name }}</label>
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
