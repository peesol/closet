@extends('layouts.app')
@section('title')
{{$shop->name.' - '}}
@endsection
@section('css')
<link href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/extra/slick-theme.css" rel="stylesheet">
<link href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/extra/slick.css" rel="stylesheet">
@endsection
@section('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

@endsection

@section('content')

<div class="container">
          @if($shop->count())
            <div class="medium-panel">
              @include('shop.partials._header', [ 'shop' => $shop ])
                    <div class="tab-nav">
                        <ul class="tab-nav-ul">
                            <button class="tab-nav-btn static current"><span class="icon-home"></span><font>{{__('message.home')}}</font></button>
                            <button class="tab-nav-btn static" onclick='document.location.href="/{{$shop->slug}}/products"'><span class="icon-silhouette"></span><font>{{__('message.product')}}</font></button>
                            <button class="tab-nav-btn static" onclick='document.location.href="/{{$shop->slug}}/collection"'><span class="icon-map"></span><font>{{__('message.collection')}}</font></button>
                            <button class="tab-nav-btn static" onclick='document.location.href="/{{$shop->slug}}/about"'><span class="icon-user"></span><font>{{__('message.about')}}</font></button>
                        </ul>
                    </div>
                    <div class="panel-body" id="full-line">
                      @if($shop->description)
                      <p>{!! nl2br(e($shop->description)) !!}</p>
                      @else
                        {{__('message.no_description')}}
                      @endif
                      @if($shop->contact->count())
                      <div>
                        @foreach($shop->contact as $contact)
                          <div class="full-label" style="height:40px">
                            @if($contact->link)
                              <span class="contact-btn {{$contact->type}} icon-{{$contact->type}}"></span>&nbsp;
                              <a class="link-text" href="{{$contact->link}}">{{$contact->body}}</a>
                            @else
                              <span class="contact-btn {{$contact->type}} icon-{{$contact->type}}"></span>&nbsp;<label class="grey-font font-light">{{$contact->body}}</label>
                            @endif
                          </div>
                        @endforeach
                      </div>
                      @endif
                    </div>

                    @if ($showcases->count())
                        @foreach ($showcases as $showcase)
                          <div class="panel-body" id="full-line">
                            <label class="heading">{{$showcase->name}}</label>
                            <div class="shop-carousel">
                                <vue-slick :products="{{$showcase->product()->get()}}" path="/product/thumbnail/" slick-for="shop"></vue-slick>
                            </div>
                          </div>
                        @endforeach
                    @else
                      @if($populars->count())
                      <div class="panel-heading-alt">
                        <label class="heading">{{__('message.popular')}}</label>
                      </div>
                      <div class="panel-body-alt">
                        <div class="shop-carousel">
                          <vue-slick :products="{{$populars}}" path="/product/thumbnail/" slick-for="shop"></vue-slick>
                        </div>
                      </div>
                      @else
                        <div class="panel-body-alt">
                          <h3 style="text-align: center; margin:50px auto;">{{__('message.no_shop_product')}}</h3>
                        </div>
                      @endif
                    @endif

            </div>
            @endif

</div>
@endsection
