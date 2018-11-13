@extends('admin.layout')

@section('content')

<div class="container">
  <div class="medium-panel">
    <div class="panel-heading">
      <label class="heading">GRANT CONSOLE</label>
    </div>
    <div class="panel-body">
      <a href="{{ route('adminHome') }}"><< BACK</a>
    </div>

    @if ($message !== null)
      <label class="heading font-green">{{$message}}</label>
    @endif

    <div class="panel-body">
      <label class="heading">GET</label>
      <form action="{{ route('grantGet') }}" method="post">
        <label for="table">Slug</label>
        <input type="text" name="shop_type">
        <button class="flat-btn" type="submit" name="button">GET</button>
        @csrf
        @method('GET')
      </form>
    </div>

    @if ($data !== null)
      <table>
        <tr>
          <th>id</th>
          <th>name</th>
          <th>type</th>
          <th>slug</th>
          <th>view</th>
        </tr>
        @foreach ($data as $value)
          <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->name }}</td>
            <td>{{ $value->usertype }}</td>
            <td>{{ $value->slug }}</td>
            <td>{{ $value->view_count }}</td>
          </tr>
          <tr>
            <td colspan="5">{{ $value->promotion_points }}</td>
          </tr>
        @endforeach
      </table>
      <div class="panel-body">
        <label class="heading">UPDATE</label>
        <form action="{{ route('grantUser') }}" method="post">
          <input type="number" name="type" placeholder="update to type">
          <input type="number" name="id" placeholder="id">
          <button class="flat-btn" type="submit" name="button">GRANT</button>
          @csrf
          @method('PUT')
        </form>
        <label class="heading">Promotions</label>
        <form action="{{ route('grantPromotion') }}" method="post">
          <input type="number" name="id" placeholder="id">
          <input type="number" name="campaign" placeholder="campaign">
          <input type="number" name="discount" placeholder="discount">
          <input type="number" name="flash_sale" placeholder="flash_sale">
          <button class="flat-btn" type="submit" name="button">GRANT</button>
          @csrf
          @method('PUT')
        </form>
      </div>
    @endif
  </div>
</div>
@endsection
