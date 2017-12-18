@extends('layouts.app')
@section('title')
{{__('message.sell')}}
@endsection
@section('css')
    <link href="{{ asset('css/dropzone-alt.css') }}" rel="stylesheet">
@endsection
@section('content')

<div class="container">
            <div class="listing-panel">
              <div class="shop-nav-bar" style="border: none;">
                  <ul class="shop-nav-ul" style="border-top: none; border-bottom: 1px solid #efefef;">
                      <button class="product-nav-btn current" onclick='document.location.href="/sell/product"'>{{__('message.new')}}</button>
                      <button class="product-nav-btn" onclick='document.location.href="/sell/used"'>{{__('message.used')}}</button>
                  </ul>
              </div>

              <div class="tab-content current">
                <product-sell></product-sell>
              </div>
            </div>
</div>

<script>
    window.addEventListener('load', function () {
        var follow = new Vue({
          el: '.container'
        });
    });

</script>

@endsection
