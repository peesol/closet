<div class="cover-wrap">
@if(Auth::check())
  @if(Auth::user()->id === $shop->user_id)
    <a href="/{{$shop->slug}}/edit"><button class="setting-btn icon-cog"></button></a>
  @else
  @endif
@endif
        <img src="{{ $shop->getCover() }}" class="shop-cover">
</div>
<div class="shop-header-wrap">
         <div class="shop-header">
       <img class="shop-thumb" src="{{ $shop->getThumbnail() }}" alt="{{ $shop->thumbnail }}">
        <div class="shop-wrapper flex">
        <div class="shop-name-link-wrap">
            <div class="name-wrap">
                <h2 class="shop-name-link">{{ $shop->name }}</h2>
            </div>
            <div class="shop-follow-btn">
                <follow-button shop-slug="{{ $shop->slug}}"></follow-button>
            </div>

        </div>
        </div>
        <shop-stats shop-slug="{{ $shop->slug}}"></shop-stats>

    </div>
    <div class="shop-vote">
         <shop-vote shop-slug="{{ $shop->slug}}"></shop-vote>
    </div>
</div>
