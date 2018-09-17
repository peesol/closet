@extends('layouts.app')
@section('title')
{{ __('user.note') . ' - '}}
@endsection

@section('content')
<div class="container">
  <div class="medium-panel">
    <div class="panel-heading">
      <label class="full-label heading">{{ __('user.note')}}</label>
    </div>
    @if (count($products))
      <div class="panel-body thumbnail-grid">
        @foreach ($products as $product)
          @include('thumbnail._products',[ 'product' => $product ])
        @endforeach
      </div>
    @else
      <div class="panel-body align-center">
        <h2 class="font-grey">{{ __('message.no_my_product') }}</h2>
      </div>
    @endif
  </div>
</div>
@endsection
