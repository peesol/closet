@extends('admin.layout')

@section('content')

<div class="container">
  <div class="medium-panel">
    <div class="panel-heading">
      <label class="heading">DATABASE RESULT</label>
    </div>
    <div class="panel-body">
      <a href="{{ route('adminHome') }}"><< BACK</a>
    </div>
    <div class="panel-body">
      @foreach ($data as $value)
        <table>
          <tr>
            <td>{{ print_r($value) }}</td>
          </tr>
        </table>
      @endforeach
    </div>
  </div>
</div>
@endsection
