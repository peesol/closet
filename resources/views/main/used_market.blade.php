@extends('layouts.app')

@section('content')
<div class="container">
  <div class="medium-panel">
    <div class="panel-heading-alt">
      <label class="heading">{{__('message.used')}}</label>
    </div>
    {{ $products->links() }}

    <div class="panel-body thumbnail-grid">
      @foreach ($products as $product)
        @include('thumbnail._products_used')
      @endforeach
    </div>

    {{ $products->links() }}
  </div>
</div>
@endsection
