@extends('layouts.app')
@section('title')
{{$product->name.' - '}}
@endsection
@section('css')
<link href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/extra/slick-theme.css" rel="stylesheet">
<link href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/extra/slick.css" rel="stylesheet">
<style>
#info{
  padding: 15px 15px;
  height: auto;
}
  @media (min-width: 768px) {
    #info{
      height: calc(100% - 153px);
    }
  }
</style>
@endsection

@section('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

@endsection
@section('content')

<div class="container">
  @if(!Auth::check())
  <div class="product-show-panel">
    <div class="panel-body" id="full-line">
      <div class="alert-box info">
        <h3 class="no-margin">
          <span class="icon-notification"></span>
          {{__('auth.login_notice')}}<a class="link-text font-bold" href="{{ route('login')}}">&nbsp;{{__('message.login')}}</a>
          {{__('auth.login_notice2')}}<a class="link-text font-bold" href="{{ route('register')}}">&nbsp;{{__('message.register')}}</a>
        </h3>
      </div>
    </div>
  </div>
  @endif
            <div class="product-show-panel">
                <div class="panel-heading"><p class="product-title">{{__('message.product_name')}} : {{ $product->name }}</p></div>
                <div class="panel-body-alt flex">
                    <div class="product-showcase">
                        @foreach ($product->productimages as $image)
                                <img src="{{config('closet.buckets.images') . '/used/photo/' . $image->filename}}" alt="{{$image->filename}}">
                        @endforeach
                    </div>

                    <div class="product-details">
                        <div class="details-header">
                            <div class="thumb">
                            <a href="/{{ $product->shop->slug}}"><img src="{{ $product->shop->getThumbnail() }}" alt="{{ $product->shop->thumbnail }}" style="float: left; width: 50px;"></a>
                                <div class="shop-name-wrap">
                                <a class="shop-name" href="/{{ $product->shop->slug}}">{{ $product->shop->name }}</a>
                                </div>
                            </div>
                            <div class="follow-btn-wrapper">
                              <follow-button shop-slug="{{ $product->shop->slug}}"></follow-button>
                            </div>

                        </div>
                        <div style="padding: 15px 15px;">
                          <h3 class="no-margin red-font">{{__('message.used')}}</h3>
                            <p class="no-margin"><span class="font-bold grey-font">{{__('message.price')}}</span> : <span class="font-bold font-large">{{ number_format($product->price) }}</span> {{__('message.baht')}}</p>
                        </div>

                        <div id="info">
                        {!! nl2br(e($product->description)) !!}
                        </div>

                    </div>
                </div>
            </div>
                <div class="product-show-panel" style="margin-top: 10px;">
                    <div class="tab-nav">
                        <ul class="tab-nav-ul">
                          <button class="tab-nav-btn static current" data-tab="tab-1">{{__('message.details')}}</button>
                          <button class="tab-nav-btn static" data-tab="tab-2" id="tab-comment">{{__('message.comment')}}</button>
                        </ul>
                    </div>
                        <div class="tab-content flex current"  style="padding: 15px 30px;" id="tab-1">
                          @foreach($contacts as $contact)
                            <div class="full-label" style="height:40px">
                              @if($contact->link)
                                <span class="contact-btn {{$contact->type}} icon-{{$contact->type}}"></span>&nbsp;
                                <a class="link-text" href="{{$contact->link}}">{{$contact->body}}<sup>*</sup></a>
                              @else
                                <span class="contact-btn {{$contact->type}} icon-{{$contact->type}}"></span>&nbsp;<label class="grey-font font-light">{{$contact->body}}</label>
                              @endif
                            </div>
                          @endforeach
                          <div class="panel-body">
                            <p class="comment">{!! nl2br(e($product->description)) !!}</p>
                          </div>
                        </div>
                        <div class="comment-vue tab-content flex" id="tab-2">
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
<script>
$('.product-showcase').slick({
    dots: true
});

$(document).ready(function(){
    $('ul.shop-nav-ul button').click(function(){
        var tab_id = $(this).attr('data-tab');
        $('ul.shop-nav-ul button').removeClass('current');
        $('.tab-content').removeClass('current');
        $(this).addClass('current');
        $("#"+tab_id).addClass('current');
    });
});
</script>

@endsection
