@extends('layouts.app')

@section('content')

<div class="container">
<div class="medium-panel padding-30-vertical">
  <h2 class="align-center font-grey">{{ __('error.404_title') }}</h2>
  <h3 class="align-center font-grey">{{ __('error.404_message') }}</h3>
  <h3 class="align-center"><a href="{{route('home')}}" class="link-text">{{ __('error.404_home_route') }}</a></h3>
</div>

</div>
@endsection
