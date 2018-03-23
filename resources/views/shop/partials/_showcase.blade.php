@foreach($showcase->product()->get() as $product)
<div class="products-wrap">
    <div class="relative">
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
            <h3 class="s-product-name"><a class="link-text" href="/product/{{ $product->uid}}">{{ $product->name }}</a></h3>
            <div class="product-detail-wrap">
              @if (!$product->discount_price)
              <p class="product-p">{{__('message.price')}} : {{ number_format($product->price) }}&#3647;</p>
              @else
              <p class="product-p">
                {{__('message.price')}}&nbsp;:&nbsp;
                <small class="icon-price-tag font-green"></small>
                <font class="font-green">{{ number_format($product->discount_price) }}&#3647;</font>
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
