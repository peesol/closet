<div class="products-wrap">
  <div class="products-img">
      <a href="/product/{{ $product->uid}}">
      <img class="products-img-thumb" src="{{$product->getImage()}}" alt="{{$product->thumbnail}}">
      </a>
      @if($product->discount_price)
      <span class="discount">Sale</span>
      <span class="price">
        <strike>{{ number_format($product->price) }}&#3647;</strike>
        {{ number_format($product->discount_price) }}&#3647;
      </span>
      @else
      <span class="price">{{ number_format($product->price) }}&#3647;</span>
      @endif
  </div>
      <h4 class="product-name"><a class="link-text" href="/product/{{ $product->uid}}">{{ $product->name }}</a></h4>
  <div class="product-detail-wrap">
    @if (!$product->discount_price)
    <p class="product-p">{{__('message.price')}} : {{ number_format($product->price) }}&#3647;</p>
    @else
    <p class="product-p">
      {{__('message.price')}}&nbsp;:&nbsp;<strike>{{ number_format($product->price) }}&#3647;</strike>
      <small class="icon-next-arrow grey-font"></small>
      <font class="green-font">{{ number_format($product->discount_price) }}&#3647;</font>
    </p>
    @endif
    @if($product->type->id !== 1)
      <p class="product-p">{{__('message.category')}} : {{ $product->type->showTranslate(App::getLocale())->name}}</p>
    @else
      <p class="product-p">{{__('message.category')}} : {{$product->subcategory->showTranslate(App::getLocale())->name}}</p>
    @endif
  </div>
</div>