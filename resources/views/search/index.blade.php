@extends('layouts.app')
@section('title')
{{__('message.search_result').' '.$keyword.' - '}}
@endsection
@section('content')

<div class="container">
  <div class="large-panel">
    <div class="panel-heading">
      <label class="heading">{{__('message.search_result')}} {{$keyword}}</label>
      <a href="https://www.algolia.com" target="_blank">
        <img class="width-120 padding-15-left" src="https://www.algolia.com/static_assets/images/press/downloads/search-by-algolia.svg" alt="">
      </a>
    </div>
      <router-view></router-view>
  </div>
</div>

@endsection
