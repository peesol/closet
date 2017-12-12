@extends('layouts.app')

@section('content')
<div class="container">
  <div class="listing-panel">
        <div class="setting-nav">
            <ul class="setting-nav-ul">
                <button class="setting-nav-btn current" data-tab="tab-1">{{ __('message.general')}}</button>
                <button class="setting-nav-btn" data-tab="tab-2">{{ __('message.contact')}}</button>
                <button class="setting-nav-btn" data-tab="tab-3">{{ __('message.showcase')}}</button>
                <button class="setting-nav-btn" data-tab="tab-4">{{ __('message.bank_account')}}</button>
            </ul>
        </div>

    <div class="tab-content current" id="tab-1">
    <shop-edit shop-name="{{$shop->name}}"
    shop-description="{{$shop->description}}"
    shop-thumbnail="{{$shop->getThumbnail()}}"
    shop-cover="{{$shop->getCover()}}"></shop-edit>
    </div>


          <div class="tab-content" id="tab-2" style="padding: 35px 35px;">
            <shop-contact-edit></shop-contact-edit>
          </div>

          <div class="tab-content flex" style="padding: 35px 35px;" id="tab-3">
            <showcase shop-id="{{$shop->id}}"></showcase>
          </div>

          <div class="tab-content flex" style="padding: 35px 35px;" id="tab-4">
            <shop-account-edit></shop-account-edit>
          </div>

  </div>
</div>
<script>
    window.addEventListener('load', function () {
        var edit = new Vue({
          el: '.container',
          data: {
            shopSlug: '{{$shop->slug}}',
          }
        });
    });
    window.addEventListener('load', function(){
        $('.setting-nav-ul button').click(function(){
            var tab_id = $(this).attr('data-tab');
            $('ul.setting-nav-ul button').removeClass('current');
            $('.tab-content').removeClass('current');
            $(this).addClass('current');
            $("#"+tab_id).addClass('current');
        });
    });
</script>
@endsection
@section('css')
<style>
  .product-nav-btn{
    margin-right: 20px !important;
  }
  .setting-nav{
    width: 100%;
    height: 52px;
    border-bottom: 1px solid #efefef;
  }
  .setting-nav-ul{
    margin: 0;
  }
  .setting-nav-ul button {
    height: 50px;
    color: #6c6c6c;
    border: none;
    background-color: #ffffff;
    font-size: 1em;
  }
  .setting-nav-btn:hover {
    color: #ff8000;
  }
  .setting-nav-btn.current{
    color: #ff8000 !important;
    border-bottom: 3px solid #ff8000;
  }
</style>
@endsection
