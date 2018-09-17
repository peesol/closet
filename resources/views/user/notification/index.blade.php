@extends('layouts.app')
@section('title')
{{ __('user.notification.title') . ' - '}}
@endsection

@section('content')
<div class="container">
  <div class="medium-panel">
    <div class="panel-heading">
      <label class="full-label heading">{{ __('user.notification.title')}}</label>
    </div>
    <notification></notification>
  </div>
</div>
@endsection
