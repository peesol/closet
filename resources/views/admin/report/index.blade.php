@extends('admin.layout')

@section('content')

<div class="container">
  <div class="medium-panel">
    <div class="panel-heading">
      <label class="heading">REPORTS</label>
    </div>

    <div class="panel-body">
      <div class="panel-body">
        <a href="{{ route('adminHome') }}"><< BACK</a>
      </div>
      @if ( Session::has('msg'))
        <div class="alert alert-success">
          <h3 class="font-link">{{ Session::get('msg') }}</h3>
        </div>
      @endif
      <table>
        <tr>
          <td>#</td>
          <td>show</td>
          <td>name</td>
          <td>email</td>
          <td>del</td>
        </tr>
        @foreach ($reports as $item)
          <tr>
            <td>{{$item->id}}</td>
            <td><i class="fas fa-chevron-down flat-btn" id="{{$item->id}}"></i></td>
            <td>{{$item->user->name}}</td>
            <td>{{$item->user->email}}</td>
            <td>
              <form class="" action="{{ route('reportDelete') }}" method="post">
                <input type="hidden" name="id" value="{{$item->id}}">
                <button type="submit" class="fas fa-trash-alt flat-btn"></button>
                @csrf
                @method('DELETE')
              </form>
            </td>
          </tr>
          <tr class="body" id="body{{$item->id}}">
            <td colspan="5">
              <u>{{$item->title}}</u><br>
              {{$item->body}}
            </td>
          </tr>
        @endforeach
      </table>
    </div>

  </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function(){
  $(".body").hide();
    $("i.fa-chevron-down").click(function(){
      $('#body' + this.id).toggle();
      $(this).toggleClass('font-red');
    });
});
</script>
@endsection
