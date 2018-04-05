@extends('layouts.app')

@section('title')
{{__('message.sell').' - '}}
@endsection

@section('css')
    <link href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/extra/dropzone-alt.css" rel="stylesheet">
@endsection

@section('content')

<div class="container">
  <div class="small-panel">

    <div class="tab-nav">
      <ul class="tab-nav-ul">
        <button class="tab-nav-btn static" onclick='document.location.href="/sell/new"'>{{__('message.new')}}</button>
        <button class="tab-nav-btn static current">{{__('message.used')}}</button>
      </ul>
    </div>

    <div class="padding-30-horizontal">
      <used-sell></used-sell>
    </div>

  </div>
</div>

@endsection
