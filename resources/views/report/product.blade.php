@extends('layouts.app')
@section('title')
{{$product->name.' - '}}
@endsection

@section('content')
<div class="container">
  <div class="medium-panel">
    <div class="panel-heading">
      <label class="full-label heading">Report</label>
    </div>
    <div class="panel-body">
      <label class="full-label input-label">{{ $product->shop->name }}</label>
      <label class="full-label input-label">{{ $product->name }}</label>
    </div>

  </div>
</div>
@endsection
