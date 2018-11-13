@foreach($showcase->product()->get() as $product)
<div class="products-wrap">
    <div class="relative">
      <a href="/product/{{ $product->uid}}">
        <img class="products-img-thumb" src="{{$product->getImage()}}" alt="{{$product->thumbnail}}">
      </a>
      @if($product->discount_price)
      <span class="sale top-right"></span>
      <span class="thumb-price-discount bottom-left">{{ number_format($product->discount_price) }}฿</span>
      @else
      <span class="price bottom-left">{{ number_format($product->price) }}฿</span>
      @endif
    </div>
            <h3 class="s-product-name"><a class="link-text" href="/product/{{ $product->uid}}">{{ $product->name }}</a></h3>
            <div class="product-detail-wrap">
              @if (!$product->discount_price)
              <p class="product-p">{{__('message.price')}} : {{ number_format($product->price) }}฿</p>
              @else
              <p class="product-p">
                {{__('message.price')}}&nbsp;:&nbsp;
                <i class="fas fa-tag font-green"></i>
                <font class="font-green">{{ number_format($product->discount_price) }}฿</font>
              </p>
              @endif
            @if($product->type->id !== 1)
            <p class="product-p">{{__('message.category')}} : {{ $product->type->showTranslate(App::getLocale())->name}}</p>
            @else
            <p class="product-p">{{__('message.category')}} : {{$product->subcategory->showTranslate(App::getLocale())->name}}</p>
            @endif
            </div>
</div>
@endforeach
