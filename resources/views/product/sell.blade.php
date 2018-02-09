@extends('layouts.app')

@section('title')
{{__('message.sell').' - '}}
@endsection

@section('css')
    <link href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/extra/dropzone-alt.css" rel="stylesheet">
@endsection
@section('content')

<div class="container">
  <div class="listing-panel">
    <div class="tab-nav" style="border: none;">
      <ul class="tab-nav-ul" style="border-top: none; border-bottom: 1px solid #efefef;">
        <button class="tab-nav-btn static current" onclick='document.location.href="/sell/product"'>{{__('message.new')}}</button>
        <button class="tab-nav-btn static" onclick='document.location.href="/sell/used"'>{{__('message.used')}}</button>
      </ul>
    </div>

    <div class="tab-content current">
      <product-sell></product-sell>
    </div>
  </div>
</div>

@endsection
