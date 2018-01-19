@extends('layouts.app')
@section('title')

@endsection
@section('content')

<div class="container">
  <div class="shop-panel">
    <div class="panel-heading"><h3 class="no-margin" style="font-weight: 600;">{{__('message.promotions_manage')}}</h3></div>
    <div class="tab-nav">
        <ul class="tab-nav-ul">
            <button class="tab-nav-btn current" data-tab="tab-1">discount code</button>
            <button class="tab-nav-btn" data-tab="tab-2">product discount</button>
            <button class="tab-nav-btn" data-tab="tab-3">flash sale</button>
        </ul>
    </div>
    <div class="panel-body">
      <!-- <div class="tab-content current" id="tab-1">
        <discount-code></discount-code>
      </div> -->
      <!-- <div class="tab-content" id="tab-1"> -->
        <product-discount></product-discount>
      <!-- </div> -->
      <!-- <div class="tab-content" id="tab-1">
        <flash-sale></flash-sale>
      </div> -->
    </div>
  </div>
</div>
<script>
window.addEventListener('load', function () {
    var promotion = new Vue({
      el: '.panel-body',
      data: {
        url: window.Closet.url,
        promotions: {
          discount: {{$promotions->discount}},
          getAnother: {{$promotions->get_another}},
          flashSale: {{$promotions->flash_sale}},
        }
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
@section('js')

@endsection
