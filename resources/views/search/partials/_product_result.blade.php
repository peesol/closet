<div class="products-wrap">
<div class="products-img">
  <a href="/product/{{ $product->uid}}">
    <img class="products-img-thumb" src="{{config('closet.buckets.images') . '/product/thumbnail/' . $product->thumbnail}}"alt="{{$product->thumbnail}} image">
  </a>
  @if (!$product->discount_price)
  <span class="price">{{ number_format($product->price) }}&#3647;</span>
  @else
  <span class="discount">Sale</span>
  <span class="price">
    <strike>{{ number_format($product->price) }}&#3647;</strike>
    <small class="icon-next-arrow"></small>
    <font>{{ number_format($product->discount_price) }}&#3647;</font>
  </span>
  @endif
</div>
            <h4 class="product-name"><a class="link-text" href="/product/{{ $product->uid}}">{{ $product->name }}</a></h4>
            <div class="product-detail-wrap">
            <p class="product-p">{{__('message.price')}} : {{ number_format($product->price) }}</p>
            @if($product->type->id !== 1)
            <p class="product-p">{{__('message.category')}} : {{ $product->type->showTranslate(App::getLocale())->name }}</p>
            @else
            <p class="product-p">{{__('message.category')}} : {{ $product->subcategory->showTranslate(App::getLocale())->name }}</p>
            @endif
            <p class="product-p">{{__('message.by')}} : <a class="link-text" href="/{{ $product->shop->slug}}">{{ $product->shop->name}}</a></p>
            </div>
</div>
