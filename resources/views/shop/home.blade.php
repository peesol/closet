@extends('layouts.app')
@section('title')
{{$shop->name.' - '}}
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

                    @if($shop->description)
                      <div class="panel-body" id="full-line">
                        <p>{!! nl2br(e($shop->description)) !!}</p>
                      </div>
                    @endif

                    @if($shop->contact->count())
                      <div class="padding-10">
                        <button class="flat-btn" @click="$root.tab = !$root.tab">{{__('message.contact')}}&nbsp;<i class="fas fa-caret-down"></i></button>
                        <div class="contacts" v-show="$root.tab">
                          <contacts-show :contacts="{{ json_encode($shop->contact->where('show', true)) }}"></contacts-show>
                        </div>
                      </div>
                    @endif

                    @if ($showcases->count())
                        @foreach ($showcases as $showcase)
                          <div class="panel-body" id="full-line">
                            <label class="heading padding-15-bottom">{{$showcase->name}}</label>
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
