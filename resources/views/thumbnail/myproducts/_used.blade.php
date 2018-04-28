@if ($products->count())

  @foreach ($products as $product)

        <div class="my-products-wrap">
        <div class="products-img">
            <a href="/product/used/{{$product->uid}}">
            <img class="products-img-thumb" src="{{$product->getImage()}}" alt="{{$product->thumbnail}}">
            </a>
            <span class="icon-refresh top-right caution"></span>
            <span class="price bottom-left">{{ number_format($product->price) }}&#3647;</span>
        </div>
        <div class="details">
          <a class="link-text product-name" href="/product/used/{{ $product->uid}}">{{ $product->name }}</a>
          <p class="product-p">{{__('message.price')}} : {{ number_format($product->price) }}&#3647;</p>
          <p class="product-p">{{ $product->category->showTranslate(App::getLocale())->name }} / {{ $product->subcategory->showTranslate(App::getLocale())->name }}</p>
          @if($product->type->id !== 1)
          <p class="product-p">{{ $product->type->showTranslate(App::getLocale())->name}}</p>
          @endif
        </div>

        <form action="/product/used/{{ $product->uid}}" method="post" class="align-right">
        <button type="submit" onclick="if(!confirm('ลบสินค้านี้?')) { return false; }" class="delete-btn round-btn">
          <small class="icon-bin"></small>
        </button>

        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        </form>

        </div>

  @endforeach

@else

<p>{{__('message.no_my_product')}}</p>

@endif
