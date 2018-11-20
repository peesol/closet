@extends('admin.layout')

@section('content')

<div class="container">
  <div class="medium-panel">
    <div class="panel-heading">
      <label class="heading">BANNER MANAGEMENT</label>
    </div>

    <div class="panel-body">
      <div class="panel-body">
        <a href="{{ route('adminHome') }}"><< BACK</a>
      </div>
      <div class="grey-bg panel-body margin-20-bottom">
        <form action="/secret/admin/banner/add" method="POST">
          <input required type="text" name="type" placeholder="type">
          <input required type="text" name="filename_mobile" placeholder="mobile">
          <input required type="text" name="filename_screen" placeholder="screen">
          <input required type="text" name="link" placeholder="link">
          <input required type="text" name="password" placeholder="password">
          <button class="flat-btn" type="submit">ADD</button>
          @csrf
        </form>
      </div>
      <table>
        <tr>
          <td>#</td>
          <td>type</td>
          <td>filename</td>
          <td>link</td>
          <td>view_count</td>
          <td>edit</td>
          <td>delete</td>
        </tr>
      @foreach ($banners as $item)
          <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->type }}</td>
            <td>{{ $item->filename }}</td>
            <td>{{ $item->link }}</td>
            <td>{{ $item->view_count ? $item->view_count : 'NULL' }}</td>
            <td>
              <a href="/secret/admin/banner/edit/{{ $item->id }}">EDIT</a>
            </td>
            <td>
              <form class="" action="/secret/admin/banner/edit/{{ $item->id }}/delete" method="post">
                <input required type="text" name="password" placeholder="PASSWORD">
                <button class="flat-btn delete" type="submit">DEL</button>
                @method('DELETE')
                @csrf
              </form>

            </td>
          </tr>
      @endforeach
      </table>
    </div>

  </div>
</div>
@endsection
