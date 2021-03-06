<div class="details-header flex flex-start-res">
    <div class="product-profile-wrap">
    <a href="/{{ $product->shop->slug}}">
    <img src="{{ $product->shop->getThumbnail() }}" alt="{{ $product->shop->thumbnail }}">
    </a>
      <div class="profile-name-wrap">
        <a class="profile-name" href="/{{ $product->shop->slug }}">{{ $product->shop->name }}&nbsp;
          @if ($product->shop_type === 2)
            <i class="fas fa-check verified-profile"></i>
          @endif
        </a>
      </div>
    </div>

    <follow-button shop-slug="{{ $product->shop->slug }}"></follow-button>

</div>

<div class="details-header-sub">
    <product-vote product-uid="{{ $product->uid }}" product-id="{{ $product->id }}"></product-vote>
    @if($product->visibility == 'public' && Auth::check())
    <collection-product product-id="{{ $product->id }}"
      product-slug="{{ $product->uid }}"
      shop-slug="{{Auth::check() ? Auth::user()->shop->slug : null}}"
      :noted="{{ $noted }}"></collection-product>
    @endif
</div>
