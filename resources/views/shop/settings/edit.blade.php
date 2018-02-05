@extends('layouts.app')
@section('title')
{{__('message.closet_edit')}}
@endsection
@section('content')
<div class="container">
  <div class="listing-panel">
        <div class="tab-nav">
            <ul class="tab-nav-ul">
                <button class="tab-nav-btn current" data-tab="tab-1">{{ __('message.general')}}</button>
                <button class="tab-nav-btn" data-tab="tab-2" id="contact">{{ __('message.contact')}}</button>
                <button class="tab-nav-btn" data-tab="tab-3" id="showcase">{{ __('message.showcase')}}</button>
                <button class="tab-nav-btn" data-tab="tab-4" id="account">{{ __('message.bank_account')}}</button>
            </ul>
        </div>

    <div class="tab-content current" id="tab-1">
    <shop-edit shop-name="{{$shop->name}}"
    shop-description="{{$shop->description}}"
    shop-thumbnail="{{$shop->getThumbnail()}}"
    shop-cover="{{$shop->getCover()}}"
    user-address="{{$shop->user->address}}"
    user-phone="{{$shop->user->phone}}"></shop-edit>
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
$('#contact').one('click', function() {
  var contact = new Vue({
    el: '#tab-2',
    data: {
      shopSlug: '{{$shop->slug}}',
    }
  });
});
$('#showcase').one('click', function() {
  var showcase = new Vue({
    el: '#tab-3',
    data: {
      shopSlug: '{{$shop->slug}}',
    }
  });
});
$('#account').one('click', function() {
  var account = new Vue({
    el: '#tab-4',
    data: {
      shopSlug: '{{$shop->slug}}',
    }
  });
});
window.addEventListener('load', function () {
    var edit = new Vue({
      el: '#tab-1',
      data: {
        shopSlug: '{{$shop->slug}}',
      }
    });
    $('.tab-nav-ul button').click(function(){
        var tab_id = $(this).attr('data-tab');
        $('ul.tab-nav-ul button').removeClass('current');
        $('.tab-content').removeClass('current');
        $(this).addClass('current');
        $("#"+tab_id).addClass('current');
    });
});
</script>
@endsection
