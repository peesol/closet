@extends('admin.layout')

@section('content')

<div class="container">
  <div class="medium-panel">
    <div class="panel-heading">
      <label class="heading">CAMPAIGN CONSOLE</label>
    </div>
    <div class="panel-body">
      <a href="{{ route('adminHome') }}"><< BACK</a>
    </div>
    <div class="panel-body">
      <form class="" action="{{ route('campaignAdd') }}" method="post">
        <label for="table">NAME</label>
        <input type="text" name="name"><br>
        <label for="where">RULES</label>
        <input name="price" type="text" placeholder="PRICE">
        <input name="etc" type="text" placeholder="ETC">
        <button class="flat-btn" type="submit" name="button">POST</button>
        @csrf
        @method('POST')
      </form>
    </div>
    <div class="panel-body">
      <table>
        <tr>
          <th>#</th>
          <th>NAME</th>
          <th>RULES</th>
          <th>DEL</th>
        </tr>
        @foreach ($campaigns as $value)
          <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->campaign }}</td>
            <td>{{ $value->rules }}</td>
            <td>
              <form action="{{ route('campaignDelete') }}" method="post">
                <input type="hidden" name="id" value="{{ $value->id }}">
                <button class="flat-btn" type="submit" name="button">DEL</button>
                @csrf
                @method('DELETE')
              </form>
            </td>
          </tr>
        @endforeach
      </table>
    </div>
  </div>
</div>
@endsection
