@extends('admin.layout')

@section('content')

<div class="container">
  <div class="medium-panel">
    <div class="panel-heading">
      <label class="heading">DATABASE CONSOLE</label>
    </div>
    <div class="panel-body">
      <a href="{{ route('adminHome') }}"><< BACK</a>
    </div>
    <div class="panel-body">
      <form class="" action="{{ route('databaseQuery') }}" method="post">
        <label for="table">Table</label>
        <input type="text" name="table"><br>
        <label for="where">Where</label>
        <input name="where" type="text" placeholder="where">
        <input name="arg" type="text" placeholder="arg">
        <input name="number" type="number" placeholder="find what">
        <button class="flat-btn" type="submit" name="button">GET</button>
        @csrf
        @method('GET')
      </form>
    </div>
    <div class="panel-body">

    </div>
  </div>
</div>
@endsection
