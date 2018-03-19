@extends('layouts.app')
@section('title')
{{$product->name.' - '}}
@endsection
@section('css')
<link href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/extra/slick-theme.css" rel="stylesheet">
<link href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/extra/slick.css" rel="stylesheet">
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
                  <label class="heading full-label">{{__('message.product_name')}} : {{ $product->name }}</label>
                </div>

                <div class="flex flex-start-res">

                  <div class="half-width-res padding-15-horizontal">
                    <vue-slick :imgs="{{json_encode($product->productimages)}}" path="/product/photo/" slick-for="product"></vue-slick>
                  </div>

                    <div class="half-width-res relative padding-15-horizontal">

                        <div class="details-header flex flex-start-res">
                            <div class="product-profile-wrap">
                            <a href="/{{ $product->shop->slug}}">
                            <img src="{{ $product->shop->getThumbnail() }}" alt="{{ $product->shop->thumbnail }}">
                            </a>
                              <div class="profile-name-wrap">
                                <a class="profile-name" href="/{{ $product->shop->slug }}">{{ $product->shop->name }}</a>
                              </div>
                            </div>

                            <follow-button shop-slug="{{ $product->shop->slug }}"></follow-button>

                        </div>


                        <div class="details-header-sub">
                            <product-vote product-uid="{{ $product->uid }}" product-id="{{ $product->id }}"></product-vote>
                            @if($product->visibility == 'public')
                            <collection-product product-id="{{ $product->id }}" shop-slug="{{Auth::check() ? Auth::user()->shop->slug : null}}"></collection-product>
                            @endif
                        </div>

                        @include('product.partials._details', [ 'product' => $product ])

                        @if(Auth::check())
                          @if(Auth::user()->id !== $product->shop_id)
                          <add-to-cart product-id="{{ $product->id }}" product-slug="{{ $product->uid }}"></add-to-cart>
                          @endif
                        @endif


                    </div>
                </div>

            </div>
                <div class="medium-panel">
                    <div class="tab-nav">
                        <ul class="tab-nav-ul">
                            <button class="tab-nav-btn static current" data-tab="#tab-1">{{__('message.details')}}</button>
                            <button class="tab-nav-btn static" data-tab="#tab-2">{{__('message.comment')}}</button>
                        </ul>
                    </div>

                        <div class="tab-content flex current" id="tab-1">
                          @include('product.partials._contacts', [ 'contacts' => $contacts ])
                        </div>

                        <div class="comment-vue tab-content flex" id="tab-2">
                          @if(!Auth::check())
                          <div class="alert-box info">
                            <label class="input-label full-label">
                              <span class="icon-notification"></span>
                              {{__('auth.comment_notice')}}<a class="link-text font-bold" href="{{ route('login')}}">&nbsp;{{__('message.login')}}</a>
                            </label>
                          </div>
                          @endif
                          <product-comment product-uid="{{ $product->uid }}"></product-comment>
                        </div>
                </div>

</div>
@endsection
