<div class="products-wrap">
<div class="products-img" onclick='document.location.href="/product/{{ $product->uid}}"'>
  <a href="/product/{{ $product->uid}}">
    <img class="products-img-thumb" src="{{config('closet.buckets.images') . '/product/thumbnail/' . $product->thumbnail}}"alt="{{$product->thumbnail}} image">
  </a>
  @if (!$product->discount_price)
  <span class="price">{{ number_format($product->price) }}฿</span>
  @else
  <span class="sale">Sale</span>
  <span class="price">
    <strike>{{ number_format($product->price) }}฿</strike>
    <small class="icon-next-arrow"></small>
    <font>{{ number_format($product->discount_price) }}฿</font>
  </span>
  @endif
  <span class="shop">{{ $product->shop->name}}</span>
</div>
            <h4 class="product-name"><a class="link-text" href="/product/{{ $product->uid}}">{{ $product->name }}</a></h4>
            <div class="product-detail-wrap">
            <p class="product-p">{{__('message.price')}} : {{ number_format($product->price) }}</p>
            <p class="product-p">{{__('message.category')}} : {{ $product->category->id }}</p>
            <p class="product-p">{{__('message.category')}} : {{ $product->subcategory->id }}</p>
            </div>
</div>
