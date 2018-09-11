@if ($products->count())

  @foreach ($products as $product)

        <div class="my-products-wrap">
        <div class="products-img">
            <a href="/product/{{ $product->uid}}">
            <img class="products-img-thumb" src="{{$product->getImage()}}" alt="{{$product->thumbnail}}">
            </a>
            @if($product->visibility === 'unlisted')
              <span class="private icon-private" style="font-size:25px;"></span>
            @endif

            @if (!$product->discount_price)
              <span class="price bottom-left">{{ number_format($product->price) }}฿</span>
            @else
            <span class="sale top-right">Sale</span>
            <span class="price bottom-left">
              <strike>{{ number_format($product->price) }}฿</strike>
              <small class="icon-next-arrow"></small>
              <font>{{ number_format($product->discount_price) }}฿</font>
            </span>
            @endif
        </div>
        <div class="details">
          <a class="link-text product-name" href="/product/{{ $product->uid}}">{{ $product->name }}</a>

          @if (!$product->discount_price)
          <p class="product-p">{{__('message.price')}} : {{ number_format($product->price) }}฿</p>
          @else
          <p class="product-p">
            {{__('message.price')}}&nbsp;:&nbsp;<strike>{{ number_format($product->price) }}฿</strike>
            <small class="icon-next-arrow font-grey"></small>
            <font class="font-green">{{ number_format($product->discount_price) }}฿</font>
          </p>
          @endif
          <p class="product-p">{{ $product->category->showTranslate(App::getLocale())->name }} / {{ $product->subcategory->showTranslate(App::getLocale())->name }}</p>
          <p class="product-p"></p>
          @if($product->type->id !== 1)
          <p class="product-p">{{ $product->type->showTranslate(App::getLocale())->name}}</p>
          @else

          @endif
        </div>

        <form action="/product/{{ $product->uid}}" method="post" class="align-right">

        <button type="button" onclick='document.location.href="/product/{{ $product->uid}}/edit"' class="edit-btn round-btn">
          <small class="icon-cog"></small>
        </button>

        <button type="submit" class="delete-btn round-btn" onclick="if(!confirm('{{ __('message.form_confirm') }}')) { return false; }">
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
