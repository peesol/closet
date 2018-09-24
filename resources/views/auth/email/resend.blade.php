@extends('layouts.app')

@section('content')
<div class="container">
  <div class="small-panel">
    <div class="panel-heading">
      <label class="heading">{{__('auth.resend')}}</label>
    </div>
    <div class="panel-body">
      @if (session('success'))
        <div class="alert-box success margin-10-bottom">
            <i class="fas fa-check font-green"></i> {{ session('success') }}
        </div>
      @elseif (session('error'))
        <div class="alert-box error margin-10-bottom">
            <i class="fas fa-exclamation-circle font-red"></i> {{ session('error') }}
        </div>
      @endif
      <form class="form-horizontal" role="form" method="POST" action="{{ route('resendEmailPost') }}">
          {{ csrf_field() }}

          <div class="form-group">
            <label for="email">{{__('auth.email')}}</label>
            <input id="email" type="email" class="form-input" name="email" required>
          </div>

          <div class="align-right padding-15-top">
            <button type="submit" class="orange-btn normal-sq">{{__('auth.resend')}}</button>
          </div>
      </form>
    </div>
  </div>
</div>
@endsection
