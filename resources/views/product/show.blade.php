@extends('layouts.app')
@section('title')
{{$product->name.' - '}}
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

                  <div class="half-width-res padding-15-horizontal">
                    <vue-slick :imgs="{{json_encode($product->productimages)}}" path="/product/photo/" slick-for="product"></vue-slick>
                  </div>

                    <div class="half-width-res relative padding-15-horizontal">

                      @include('product.partials._heading')

                      @include('product.partials._details', [ 'product' => $product ])

                        @if(Auth::check())
                          @if(Auth::user()->id !== $product->shop_id)
                            <add-to-cart product-id="{{ $product->id }}" product-slug="{{ $product->uid }}"></add-to-cart>
                          @endif
                        @endif

                    </div>

                </div>

            </div>
            @include('product.partials._tab')

</div>
@endsection
