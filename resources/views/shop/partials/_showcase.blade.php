@foreach($showcase->product()->get() as $product)
<div class="products-wrap p-carousel-margin">
    <div class="">
            <a href="/product/{{ $product->uid}}">
            <img class="products-img-thumb" src="{{$product->getImage()}}" alt="{{$product->thumbnail}}">
            </a>
    </div>
            <h3 class="s-product-name"><a class="link-text" href="/product/{{ $product->uid}}">{{ $product->name }}</a></h3>
            <div class="product-detail-wrap">
            <p class="product-p">{{__('message.price')}} : {{ number_format($product->price) }}</p>
            @if($product->type->id !== 1)
            <p class="product-p">{{__('message.category')}} : {{ $product->type->showTranslate(App::getLocale())->name}}</p>
            @else
            <p class="product-p">{{__('message.category')}} : {{$product->subcategory->showTranslate(App::getLocale())->name}}</p>
            @endif
            </div>
</div>
@endforeach
