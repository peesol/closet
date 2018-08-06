@extends('admin.layout')

@section('content')

<div class="container">
  <div class="medium-panel">
    <div class="panel-heading">
      <label class="heading">ADMINISTRATION CONSOLE</label>
    </div>
    <div class="panel-body">
      <li><a href="{{ route('bannerAdmin')}}">Banner</a></li>
      <li><a href="{{ route('productAdmin')}}">Product</a></li>
    </div>

  </div>
</div>

@endsection
