<div class="cover-wrap">
@if(Auth::check())
  @if(Auth::user()->id === $shop->user_id)
    <a href="/{{$shop->slug}}/edit"><button class="align-top-right icon-cog round-btn"></button></a>
  @else
  @endif
@endif
        <img src="{{ $shop->getCover() }}">
</div>
<div class="profile-header-wrap" id="full-line">
  <div class="profile-info-wrap panel-body">

    <div class="profile-thumbnail">
      <img class="" src="{{ $shop->getThumbnail() }}" alt="{{ $shop->thumbnail }}">
    </div>

    <div class="profile-header-row">
      <label class="profile-name">{{ $shop->name }}</label>

      <follow-button shop-slug="{{ $shop->slug}}"></follow-button>
    </div>

      <shop-stats shop-slug="{{ $shop->slug}}"></shop-stats>

  </div>

  <div class="profile-vote panel-body">
       <shop-vote shop-slug="{{ $shop->slug}}"></shop-vote>
  </div>
</div>
