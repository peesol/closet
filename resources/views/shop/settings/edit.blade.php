@extends('layouts.app')
@section('title')
{{__('message.closet_edit').' - '}}
@endsection
@section('content')
<div class="container">
  <div class="listing-panel">
        <div class="tab-nav">
            <ul class="tab-nav-ul">
                <button class="tab-nav-btn current" data-tab="tab-1">{{ __('message.general')}}</button>
                <button class="tab-nav-btn" data-tab="tab-2">{{ __('message.contact')}}</button>
                <button class="tab-nav-btn" data-tab="tab-3">{{ __('message.showcase')}}</button>
                <button class="tab-nav-btn" data-tab="tab-4">{{ __('message.bank_account')}}</button>
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
