@extends('layouts.app')
@section('title')
{{$shop->name.' - '}}
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
                        <ul class="tab-nav-ul static">
                            <button class="tab-nav-btn current"><i class="fas fa-home"></i><font>{{__('message.home')}}</font></button>
                            <button class="tab-nav-btn" onclick='document.location.href="/{{$shop->slug}}/products"'><i class="fas fa-shopping-bag"></i><font>{{__('message.product')}}</font></button>
                            <button class="tab-nav-btn" onclick='document.location.href="/{{$shop->slug}}/collection"'><i class="fas fa-map"></i><font>{{__('message.collection')}}</font></button>
                            <button class="tab-nav-btn" onclick='document.location.href="/{{$shop->slug}}/about"'><i class="fas fa-user"></i><font>{{__('message.about')}}</font></button>
                            <button class="tab-nav-btn" onclick='document.location.href="/{{$shop->slug}}/reviews"'><i class="fas fa-star"></i><font>{{__('message.review')}}</font></button>
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
                              <span class="contact-btn {{$contact->type}} fas fa-{{$contact->type}}"></span>&nbsp;
                              <a class="link-text" href="{{$contact->link}}">{{$contact->body}}</a>
                            @else
                              <span class="contact-btn {{$contact->type}} fas fa-{{$contact->type}}"></span>&nbsp;<label class="font-grey font-light">{{$contact->body}}</label>
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
                      <div class="products-carousel">
                        <vue-slick :products="{{$populars}}" path="/product/thumbnail/" slick-for="shop"></vue-slick>
                      </div>
                      @else
                        <div class="panel-body-alt align-center">
                          <h2 class="font-grey">{{__('message.no_shop_product')}}</h2>
                        </div>
                      @endif
                    @endif

            </div>
            @endif

</div>
@endsection
