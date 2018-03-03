@extends('layouts.app')
@section('title')
{{__('message.closet_edit')}}
@endsection
@section('content')
<div class="container">
  <div class="small-panel">

        <div class="tab-nav">
            <div class="tab-nav-ul">
                <button class="tab-nav-btn current" data-tab="#tab-1">{{ __('message.general')}}</button>
                <button class="tab-nav-btn" data-tab="#tab-2">{{ __('message.contact')}}</button>
                <button class="tab-nav-btn" data-tab="#tab-3">{{ __('message.showcase')}}</button>
                <button class="tab-nav-btn" data-tab="#tab-4">{{ __('message.bank_account')}}</button>
            </div>
        </div>

        <div class="tab-content current" id="tab-1">
          <shop-edit shop-name="{{$shop->name}}"
            shop-description="{{$shop->description}}"
            profile-thumbnailnail="{{$shop->getThumbnail()}}"
            shop-cover="{{$shop->getCover()}}"
            shop-slug="{{$shop->slug}}"
            user-address="{{$shop->user->address}}"
            user-phone="{{$shop->user->phone}}"></shop-edit>
          </div>

          <div class="tab-content" style="padding: 35px 35px;" id="tab-2">
            <shop-contact-edit shop-slug="{{$shop->slug}}"></shop-contact-edit>
          </div>

          <div class="tab-content flex" style="padding: 35px 35px;" id="tab-3">
            <showcase shop-slug="{{$shop->slug}}"></showcase>
          </div>

          <div class="tab-content flex" style="padding: 35px 35px;" id="tab-4">
            <shop-account-edit shop-slug="{{$shop->slug}}"></shop-account-edit>
          </div>

  </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
window.addEventListener("load",function(){var t=document.querySelectorAll(".tab-nav-btn");function e(e){for(var r=0;r<t.length;r++)t[r].classList.remove("current");e.currentTarget.classList.add("current"),e.preventDefault();var n=document.querySelectorAll(".tab-content");for(r=0;r<n.length;r++)n[r].classList.remove("current");var a=e.target.getAttribute("data-tab");document.querySelector(a).classList.add("current")}for(i=0;i<t.length;i++)t[i].addEventListener("click",e)});
</script>
@endsection
