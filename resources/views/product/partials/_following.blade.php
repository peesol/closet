<div class="products-wrap products-margin">
    <div class="products-img">
        @foreach ($product->productimages as $productimage)
            @if ($loop->first)
            <a href="/product/{{ $product->uid}}">
            <img class="products-img-thumb" src="{{config('closet.buckets.images') . '/product/' . $productimage->filename}}">
            </a>
            @elseif ($productimage->count() > 1)
            <img class="multi-icon" src="{{config('closet.buckets.images') . '/misc/' .'multi-icon.png' }}">
            @endif
            @endforeach
    </div>
            <h4 class="product-name"><a class="link-text" href="/product/{{ $product->uid}}">{{ $product->product_name }}</a></h4>                         
            <div class="product-detail-wrap">
            <p class="product-p">Price : {{ $product->price }}</p>
            <p class="product-p">Category : {{ $product->category->name}}</p>
            <p class="product-p">By : <a class="link-text" href="/shop/{{ $product->shop->slug}}">{{ $product->shop->name}}</a></p>
            </div>

</div>
