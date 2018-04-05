@extends('layouts.app')
@section('title')
{{'My note - '}}
@endsection

@section('content')
<div class="container">
  <div class="medium-panel">
    <div class="panel-heading">
      <label class="full-label heading">{{ __('user.note')}}</label>
    </div>
    <div class="panel-body thumbnail-grid">
      @foreach ($products as $product)
        @include('thumbnail._products',[ 'product' => $product ])
      @endforeach
    </div>
  </div>
</div>
@endsection
