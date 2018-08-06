@extends('admin.layout')

@section('content')

<div class="container">
  <div class="medium-panel">
    <div class="panel-heading">
      <label class="heading">BANNER MANAGEMENT</label>
    </div>
    <table>
      <tr>
        <td>#</td>
        <td>type</td>
        <td>filename</td>
        <td>link</td>
        <td>view_count</td>
      </tr>
      <tr>
        <td>{{ $banner->id }}</td>
        <td>{{ $banner->type }}</td>
        <td>{{ $banner->filename }}</td>
        <td>{{ $banner->link }}</td>
        <td>{{ $banner->view_count ? $banner->view_count : 'NULL' }}</td>
      </tr>
    </table>
    <div class="panel-body">
      @if ( Session::has('msg'))
        <div class="alert alert-success">
          <h3 class="font-link">{{ Session::get('msg') }}</h3>
        </div>
      @endif
      <form action="{{ route('bannerUpdate', $banner->id)}}" method="POST">
        <input required type="text" name="type" placeholder="type">
        <input required type="text" name="filename" placeholder="filename">
        <input required type="text" name="link" placeholder="link">
        <input required type="text" name="password" placeholder="password">
        <button class="flat-btn" type="submit">EDIT</button>
        {{ method_field('PUT') }}
        @csrf
      </form>

    </div>
  </div>
</div>

@endsection
