<div class="products-wrap">
  <div class="products-img">
      <a href="/product/{{ $product->uid}}">
        <img class="products-img-thumb" src="{{$product->getImage()}}" alt="{{$product->thumbnail}}">
      </a>

      @if ($product->shop_type === 2)
        <i class="fas fa-check verified-profile top-left"></i>
      @endif

      @if($product->discount_price)
        <span class="sale top-right">Sale</span>
        <span class="thumb-price-discount bottom-left">{{ number_format($product->discount_price) }}฿</span>
      @else
        <span class="price bottom-left">{{ number_format($product->price) }}฿</span>
      @endif

  </div>

  <div class="details">
    <a class="link-text product-name" href="/product/{{ $product->uid}}">{{ $product->name }}</a>

    @if (!$product->discount_price)
      <p class="product-p">{{__('message.price')}}&nbsp;{{ number_format($product->price) }}฿</p>
    @else
      <p class="product-p">
        {{__('message.price')}}&nbsp;<s>{{ number_format($product->price) }}฿</s>&nbsp;
        <font class="font-green">{{ number_format($product->discount_price) }}฿</font>
      </p>
    @endif
  </div>

</div>
