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
      <label class="heading">GET</label>
      <form action="{{ route('databaseQuery') }}" method="post">
        <label for="table">Table</label>
        <input type="text" name="table"><br>
        <label for="where">Where</label>
        <input name="where" type="text" placeholder="where">
        <input name="arg" type="text" placeholder="arg">
        <input name="number" type="text" placeholder="find what">
        <button class="flat-btn" type="submit" name="button">GET</button>
        @csrf
        @method('GET')
      </form>
    </div>
    <div class="panel-body">
      <label class="heading">UPDATE</label>
      <form action="{{ route('databaseInsert') }}" method="post">
        <label for="table">Table</label>
        <input type="text" name="table"><br>
        <label for="where">Where</label>
        <input name="where" type="text" placeholder="where">
        <input name="arg" type="text" placeholder="operator">
        <input name="number" type="text" placeholder="find what"><br>
        <input name="column" type="text" placeholder="column">
        <input name="value" type="text" placeholder="value"><br>
        <input name="password" type="text" placeholder="password">
        <button class="flat-btn" type="submit" name="button">UPDATE</button>
        @csrf
        @method('PUT')
      </form>
    </div>
  </div>
</div>
@endsection
