<div class="products-wrap">
  <div class="products-img">
      <a href="/product/{{ $product->uid}}">
        <img class="products-img-thumb" src="{{$product->getImage()}}" alt="{{$product->thumbnail}}">
      </a>
      <i class="fas fa-redo-alt caution top-right"></i>
  </div>

  <div class="details">
    <a class="link-text product-name" href="/product/{{ $product->uid}}">{{ $product->name }}</a>

    <p class="product-p">{{__('message.price')}}&nbsp;{{ number_format($product->price) }}฿</p>

  </div>

</div>
