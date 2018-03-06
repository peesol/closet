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
                        <ul class="tab-nav-ul">
                          <button class="tab-nav-btn static" onclick='document.location.href="/{{$shop->slug}}"'><span class="icon-home"></span><font>{{__('message.home')}}</font></button>
                          <button class="tab-nav-btn static" onclick='document.location.href="/{{$shop->slug}}/products"'><span class="icon-silhouette"></span><font>{{__('message.product')}}</font></button>
                          <button class="tab-nav-btn static" onclick='document.location.href="/{{$shop->slug}}/collection"'><span class="icon-map"></span><font>{{__('message.collection')}}</font></button>
                          <button class="tab-nav-btn static current"><span class="icon-user"></span><font>{{__('message.about')}}</font></button>
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
                <h3>{{__('message.contact')}}</h3>
                <div class="">
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
        </div>

@endif

</div>

@endsection
