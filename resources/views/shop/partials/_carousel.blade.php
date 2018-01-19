<div class="products-wrap p-carousel-margin">
    <div class="relative">
      <a href="/product/{{ $product->uid}}">
        <img class="products-img-thumb" src="{{$product->getImage()}}" alt="{{$product->thumbnail}}">
      </a>
      @if($product->discount_price)
      <span class="discount">Sale</span>
      <span class="discount-price">
        <p class="no-margin"><strike>{{ number_format($product->price) }}&#3647;</strike></p>
        <p class="no-margin">{{ number_format($product->discount_price) }}&#3647;</p>
      </span>
      @endif
    </div>
      <h3 class="s-product-name"><a class="link-text" href="/product/{{ $product->uid}}">{{ $product->name }}</a></h3>
        <div class="product-detail-wrap">
          @if (!$product->discount_price)
          <p class="product-p">{{__('message.price')}} : {{ number_format($product->price) }}&#3647;</p>
          @else
          <p class="product-p">
            {{__('message.price')}}&nbsp;:&nbsp;
            <small class="icon-price-tag green-font"></small>
            <font class="green-font">{{ number_format($product->discount_price) }}&#3647;</font>
          </p>
          @endif
          @if($product->type->id !== 1)
          <p class="product-p">{{__('message.category')}}&nbsp;:&nbsp;{{ $product->type->showTranslate(App::getLocale())->name}}</p>
          @else
          <p class="product-p">{{__('message.category')}}&nbsp;:&nbsp;{{$product->subcategory->showTranslate(App::getLocale())->name}}</p>
          @endif
        </div>
</div>
