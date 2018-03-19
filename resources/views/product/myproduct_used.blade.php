@extends('layouts.app')
@section('title')
{{__('message.my_product').' - '}}
@endsection
@section('content')

<div class="container">
            <div class="large-panel">
                <div class="panel-heading"><h3 class="no-margin">{{__('message.my_product')}}</h3></div>
                <div class="tab-nav">
                    <ul class="tab-nav-ul">
                      <button class="tab-nav-btn static" onclick='document.location.href="/profile/myproduct/new"'>{{__('message.new')}}</button>
                      <button class="tab-nav-btn static current">{{__('message.used')}}</button>
                    </ul>
                </div>

                @if(count($products) > 10)
                <div class="pagination-wrap">{{ $products->links() }}</div>
                @endif

                <div class="panel-body thumbnail-grid">

                    @if ($products->count())

                    	@foreach ($products as $product)

                            <div class="my-products-wrap">
                            <div class="products-img">
                              <button class="caution round-btn">
                                <span class="icon-refresh"></span>
                              </button>
                                <a href="/product/used/{{$product->uid}}">
                                <img class="products-img-thumb" src="{{$product->getImage()}}" alt="{{$product->thumbnail}}">
                                </a>
                                <span class="price">{{ number_format($product->price) }}</span>
                            </div>

                            <h4 class="product-name"><a class="link-text" href="/product/used/{{ $product->uid}}">{{ $product->name }}</a></h4>
                            <div class="product-detail-wrap">
                            <p class="product-p">{{__('message.price')}} : {{ number_format($product->price) }}</p>
                            <p class="product-p">{{ $product->category->showTranslate(App::getLocale())->name }} / {{ $product->subcategory->showTranslate(App::getLocale())->name }}</p>
                                    @if($product->type->id !== 1)
                                    <p class="product-p">{{ $product->type->showTranslate(App::getLocale())->name}}</p>
                                    @else

                                    @endif
                            </div>

                            <form action="/product/used/{{ $product->uid}}" method="post">
                            <button type="submit" class="delete-btn round-btn" style="margin:10px 0 0 0px; position:absolute; bottom:0;">
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
