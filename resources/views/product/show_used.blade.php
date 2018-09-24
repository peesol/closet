@extends('layouts.app')
@section('title')
{{$product->name.' - '}}
@endsection

@section('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
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
                      <vue-slick :imgs="{{json_encode($product->productimages)}}" path="/used/photo/"></vue-slick>
                    </div>

                    <div class="half-width-res relative">

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
                        <div class="details-header">
                          <label class="input-label font-red">{{__('message.used')}}</label>
                          <p class="no-margin">
                            <span class="font-bold font-grey">{{__('message.price')}}</span> : <span class="font-bold font-large">{{ number_format($product->price) }}</span>&nbsp;฿
                          </p>
                        </div>

                        <contacts-show :contacts="{{ json_encode($contacts) }}"></contacts-show>

                    </div>
                </div>
            </div>

    <div class="medium-panel">

      <div class="panel-heading">
        <label class="heading">{{__('message.details')}}</label>
      </div>

      <div class="panel-body-alt">
        <p>{!! nl2br(e($product->description)) !!}</p>
      </div>

    </div>


</div>
@endsection
