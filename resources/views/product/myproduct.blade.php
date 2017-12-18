@extends('layouts.app')
@section('title')
{{__('message.my_product')}}
@endsection
@section('content')

<div class="container">
            <div class="large-panel">
                <div class="panel-heading"><h3 class="no-margin">{{__('message.my_product')}}</h3></div>
                <div class="shop-nav-bar" style="border: none;">
                    <ul class="shop-nav-ul" style="border-top: none; border-bottom: 1px solid #efefef;">
                      <button class="product-nav-btn current">{{__('message.new')}}</button>
                      <button class="product-nav-btn" onclick='document.location.href="/profile/myproduct/used"'>{{__('message.used')}}</button>
                    </ul>
                </div>
                @if ($products->count())
                <div class="no-border-heading margin-top-10px">
                  <button class="btn" onclick='document.location.href="/profile/myproduct/stock"'>{{__('message.stock_edit')}}</button>
                  <button class="btn" onclick='document.location.href="/profile/myproduct/options"' style="margin-left:20px;">{{__('message.shipping_edit')}}</button>
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
                            </div>

                            <h3 class="product-name"><a class="link-text" href="/product/{{ $product->uid}}">{{ $product->name }}</a></h3>
                            <div class="product-detail-wrap">
                            <p class="product-p">{{__('message.price')}} : {{ number_format($product->price) }}</p>
                            <p class="product-p">{{ $product->category->showTranslate(App::getLocale())->name }}</p>
                            <p class="product-p">{{ $product->subcategory->showTranslate(App::getLocale())->name }}</p>
                                    @if($product->type->id !== 1)
                                    <p class="product-p">{{ $product->type->showTranslate(App::getLocale())->name}}</p>
                                    @else

                                    @endif
                            </div>

                            <form action="/product/{{ $product->uid}}" method="post">

                            <a href="/product/{{ $product->uid}}/edit" class="btn" style="margin:10px 0 0 0; position:absolute; bottom:0;">{{__('message.edit')}}</a>

                            <button type="submit" class="danger-btn" style="margin:10px 0 0 80px; position:absolute; bottom:0;">{{__('message.delete')}}</button>

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
    $(".danger-btn").click(function() {
            if(confirm('Are you sure you want to delete this?')){
                return true;
            }
            return false;
        });
</script>
@endsection
