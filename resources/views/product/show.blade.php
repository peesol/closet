@extends('layouts.app')
@section('title')
{{$product->name.' - '}}
@endsection
{{-- @section('og-image')
https://s3-ap-southeast-1.amazonaws.com/files.closet/product/thumbnail/{{ $product->thumbnail }}
@endsection --}}
@section('og-title')
{{ $product->name }}
@endsection
@section('fb-events')
<script>
  fbq('track', 'ViewContent', {
    content_ids: {{ $product->id }},
    content_type: 'product',
  });
</script>
<header>
 <meta property="og:description" content="{{ $product->description }}">
 <meta property="product:brand" content="unidentified">
 <meta property="product:availability" content="{{ $product->stock ? 'in stock' : 'out of stock' }}">
 <meta property="product:condition" content="new">
 <meta property="product:price:amount" content="{{ $product->price }}">
 <meta property="product:price:currency" content="THB">
 <meta property="product:retailer_item_id" content="{{ $product->id }}">
</header>
@endsection

@section('scripts')
<script type="text/javascript">
window.addEventListener("load",function(){var t=document.querySelectorAll(".tab-nav-btn");function e(e){for(var r=0;r<t.length;r++)t[r].classList.remove("current");e.currentTarget.classList.add("current"),e.preventDefault();var n=document.querySelectorAll(".tab-content");for(r=0;r<n.length;r++)n[r].classList.remove("current");var a=e.target.getAttribute("data-tab");document.querySelector(a).classList.add("current")}for(i=0;i<t.length;i++)t[i].addEventListener("click",e)});
</script>
@endsection
@section('content')
<div class="container">
  @include('product.partials._login_warn')
            <div class="medium-panel">
                <div class="panel-heading margin-10-bottom">
                  <label class="heading full-label">{{ $product->name }}</label>
                </div>

                <div class="product-show-wrap">

                  <div class="half-width-res">
                    <vue-slick :imgs="{{json_encode($product->productimages)}}" path="/product/photo/" slick-for="product"></vue-slick>
                  </div>

                    <div class="half-width-res relative">

                      @include('product.partials._heading')

                      @include('product.partials._details', [ 'product' => $product ])

                      @if (Auth::check() && $product->stock && $product->shop_id !== Auth::id())
                        <add-to-cart :product-stock="{{ $product->amount }}" product-slug="{{ $product->uid }}"></add-to-cart>
                      @endif


                    </div>

                </div>

            </div>
            @include('product.partials._tab')

</div>
@endsection
