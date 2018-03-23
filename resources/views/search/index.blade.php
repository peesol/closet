@extends('layouts.app')
@section('title')
{{$keyword.' - '}}
@endsection
@section('content')

<div class="container">
  <div class="large-panel">
    <div class="panel-heading">
      <label class="full-label heading">{{__('message.search_result')}} {{$keyword}}</label>
    </div>
      <router-view></router-view>
  </div>
</div>

@endsection
