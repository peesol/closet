@extends('layouts.app')
@section('title')
{{$shop->name.' - '}}
@endsection
@section('content')

<div class="container">
            @if($shop->count())
            <div class="medium-panel">
              @include('shop.partials._header',[
                  'shop' => $shop
              ])
                    <div class="tab-nav">
                        <ul class="tab-nav-ul static">
                          <button class="tab-nav-btn" onclick='document.location.href="/{{$shop->slug}}"'><i class="fas fa-home"></i><font>{{__('message.home')}}</font></button>
                          <button class="tab-nav-btn" onclick='document.location.href="/{{$shop->slug}}/products"'><i class="fas fa-shopping-bag"></i><font>{{__('message.product')}}</font></button>
                          <button class="tab-nav-btn" onclick='document.location.href="/{{$shop->slug}}/collection"'><i class="fas fa-map"></i><font>{{__('message.collection')}}</font></button>
                          <button class="tab-nav-btn current"><i class="fas fa-user"></i><font>{{__('message.about')}}</font></button>
                          <button class="tab-nav-btn" onclick='document.location.href="/{{$shop->slug}}/reviews"'><i class="fas fa-star"></i><font>{{__('message.review')}}</font></button>
                        </ul>
                    </div>
            <div class="panel-heading-alt">
              <label class="heading">{{__('message.about')}}
              </label>
            </div>
            <div class="panel-body-alt">
                @if($shop->description !== null)
                    <label class="heading">{{__('message.description')}}</label>
                    <div class="about-description">
                    <p>{!! nl2br(e($shop->description)) !!}</p>
                    </div>
                @else
                    {{__('message.no_description')}}
                @endif

                @if($shop->contact->count())
                <label class="heading">{{__('message.contact')}}</label>
                <div class="">
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
        </div>

@endif

</div>

@endsection
