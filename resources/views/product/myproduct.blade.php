@extends('layouts.app')
@section('title')
{{__('message.my_product').' - '}}
@endsection
@section('content')

<div class="container">
            <div class="large-panel">
                <div class="panel-heading"><h3 class="no-margin">{{__('message.my_product')}}</h3></div>
                <div class="tab-nav" style="border: none;">
                    <ul class="tab-nav-ul" style="border-top: none; border-bottom: 1px solid #efefef;">
                      <button class="tab-nav-btn static current">{{__('message.new')}}</button>
                      <button class="tab-nav-btn static" onclick='document.location.href="/profile/myproduct/used"'>{{__('message.used')}}</button>
                    </ul>
                </div>
                @if ($products->count())
                <div class="panel-heading margin-10-top">
                  <button class="orange-btn normal-sq" onclick='document.location.href="/profile/myproduct/stock"'>{{__('message.stock_edit')}}</button>
                  <button class="orange-btn normal-sq" onclick='document.location.href="/profile/myproduct/shipping"' style="margin-left:20px;">{{__('message.shipping_edit')}}</button>
                </div>
                @endif

                @if(count($products) > 10)
                <div class="pagination-wrap">{{ $products->links() }}</div>
                @endif

                <div class="panel-body thumbnail-grid">

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
                            <div class="padding-5">
                              <h4 class="product-name"><a class="link-text" href="/product/{{ $product->uid}}">{{ $product->name }}</a></h4>

                              @if (!$product->discount_price)
                              <p class="product-p">{{__('message.price')}} : {{ number_format($product->price) }}&#3647;</p>
                              @else
                              <p class="product-p">
                                {{__('message.price')}}&nbsp;:&nbsp;<strike>{{ number_format($product->price) }}&#3647;</strike>
                                <small class="icon-next-arrow grey-font"></small>
                                <font class="green-font">{{ number_format($product->discount_price) }}&#3647;</font>
                              </p>
                              @endif
                              <p class="product-p">{{ $product->category->showTranslate(App::getLocale())->name }} / {{ $product->subcategory->showTranslate(App::getLocale())->name }}</p>
                              <p class="product-p"></p>
                              @if($product->type->id !== 1)
                              <p class="product-p">{{ $product->type->showTranslate(App::getLocale())->name}}</p>
                              @else

                              @endif
                            </div>

                            <form action="/product/{{ $product->uid}}" method="post">

                            <button type="button" onclick='document.location.href="/product/{{ $product->uid}}/edit"' class="edit-btn round-btn">
                              <small class="icon-cog"></small>
                            </button>

                            <button type="submit" class="delete-btn round-btn" >
                              <small class="icon-bin no-margin"></small>
                            </button>

                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            </form>

                            </div>

                    	@endforeach

                    @else

                    <p>{{__('message.no_my_product')}}</p>

                    @endif

                </div>
                @if(count($products) > 10)
                <div class="pagination-wrap">{{ $products->links() }}</div>
                @endif
            </div>
</div>
<script>
    $(".delete-btn").click(function() {
            if(confirm('Are you sure you want to delete this?')){
                return true;
            }
            return false;
        });
</script>
@endsection
