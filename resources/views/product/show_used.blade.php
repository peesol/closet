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

                    <div class="half-width-res padding-15-horizontal">
                      <vue-slick :imgs="{{json_encode($product->productimages)}}" path="/used/photo/"></vue-slick>
                    </div>

                    <div class="half-width-res relative padding-15-horizontal">

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

                        @if ($contacts->count())
                        <div class="panel-body">
                          @foreach($contacts as $contact)
                            <div class="full-label padding-15-horizontal" style="height:40px">
                              @if($contact->link)
                                <span class="contact-btn {{$contact->type}} icon-{{$contact->type}}"></span>&nbsp;
                                <a class="link-text" href="{{$contact->link}}">{{$contact->body}}<sup>*</sup></a>
                              @else
                                <span class="contact-btn {{$contact->type}} icon-{{$contact->type}}"></span>&nbsp;<label class="font-grey font-light">{{$contact->body}}</label>
                              @endif
                            </div>
                          @endforeach
                        </div>
                        @endif

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
