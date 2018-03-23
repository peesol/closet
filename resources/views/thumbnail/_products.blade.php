<div class="products-wrap">
  <div class="products-img">
      <a href="/product/{{ $product->uid}}">
        <img class="products-img-thumb" src="{{$product->getImage()}}" alt="{{$product->thumbnail}}">
      </a>

      @if($product->discount_price)
        <span class="sale top-right">Sale</span>
        <span class="price bottom-left">
          <strike>{{ number_format($product->price) }}&#3647;</strike>
          {{ number_format($product->discount_price) }}&#3647;
        </span>
      @else
        <span class="price bottom-left">{{ number_format($product->price) }}&#3647;</span>
      @endif
  </div>

  <div class="details">
    <a class="link-text product-name" href="/product/{{ $product->uid}}">{{ $product->name }}</a>

    @if (!$product->discount_price)
      <p class="product-p">{{__('message.price')}}&nbsp;{{ number_format($product->price) }}&#3647;</p>
    @else
      <p class="product-p">
        {{__('message.price')}}&nbsp;<strike>{{ number_format($product->price) }}&#3647;</strike>
        <small class="icon-next-arrow grey-font"></small>
        <font class="font-green">{{ number_format($product->discount_price) }}&#3647;</font>
      </p>
    @endif
  </div>

</div>
