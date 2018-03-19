@extends('layouts.app')
@section('title')
{{$product->name.' - '}}
@endsection
@section('css')
<link href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/extra/slick-theme.css" rel="stylesheet">
<link href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/extra/slick.css" rel="stylesheet">
@endsection

@section('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script type="text/javascript">
window.addEventListener("load",function(){var t=document.querySelectorAll(".tab-nav-btn");function e(e){for(var r=0;r<t.length;r++)t[r].classList.remove("current");e.currentTarget.classList.add("current"),e.preventDefault();var n=document.querySelectorAll(".tab-content");for(r=0;r<n.length;r++)n[r].classList.remove("current");var a=e.target.getAttribute("data-tab");document.querySelector(a).classList.add("current")}for(i=0;i<t.length;i++)t[i].addEventListener("click",e)});
</script>
@endsection
@section('content')

<div class="container">
  @include('product.partials._login_warn')
            <div class="product-show-panel">
                <div class="panel-heading margin-10-bottom"><p class="product-title">{{__('message.product_name')}} : {{ $product->name }}</p></div>
                <div class="flex">

                    <div class="product-showcase">
                      <vue-slick :imgs="{{json_encode($product->productimages)}}" path="/used/photo/"></vue-slick>
                    </div>

                    <div class="product-details">
                        <div class="details-header">
                            <div class="product-profile-wrap">
                            <a href="/{{ $product->shop->slug}}"><img src="{{ $product->shop->getThumbnail() }}" alt="{{ $product->shop->thumbnail }}" style="float: left; width: 50px;"></a>
                                <div class="profile-name-wrap">
                                <a class="profile-name" href="/{{ $product->shop->slug}}">{{ $product->shop->name }}</a>
                                </div>
                            </div>
                            <div class="follow-btn-wrapper">
                              <follow-button shop-slug="{{ $product->shop->slug}}"></follow-button>
                            </div>

                        </div>
                        <div class="panel-body">
                          <h3 class="no-margin red-font">{{__('message.used')}}</h3>
                          <p class="no-margin"><span class="font-bold grey-font">{{__('message.price')}}</span> : <span class="font-bold font-large">{{ number_format($product->price) }}</span> {{__('message.baht')}}</p>
                        </div>

                        <div class="panel-body">
                        <p class="comment">{!! nl2br(e($product->description)) !!}</p>
                        </div>

                    </div>
                </div>
            </div>
  <div class="product-show-panel" style="margin-top: 10px;">
    <div class="tab-nav">
      <ul class="tab-nav-ul">
        <button class="tab-nav-btn static current" data-tab="#tab-1">{{__('message.details')}}</button>
        <button class="tab-nav-btn static" data-tab="#tab-2">{{__('message.comment')}}</button>
      </ul>
    </div>

    <div class="tab-content flex current" id="tab-1">
      @include('product.partials._contacts', [ 'contacts' => $contacts ])
    </div>

    <div class="tab-content flex" id="tab-2">
      @if(!Auth::check())
      <div class="alert-box info">
        <h3 class="no-margin">
          <span class="icon-notification"></span>
          {{__('auth.comment_notice')}}<a class="link-text font-bold" href="{{ route('login')}}">&nbsp;{{__('message.login')}}</a>
        </h3>
      </div>
      @endif
        <used-comment product-uid="{{ $product->uid }}"></used-comment>
    </div>
  </div>

</div>
@endsection
