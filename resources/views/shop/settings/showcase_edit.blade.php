@extends('layouts.app')

@section('title')
{{__('message.showcase_edit').' - '}}
@endsection

@section('content')

<div class="container">
  <div class="medium-panel">
    <div class="panel-heading">
      <label class="full-label heading">{{__('message.showcase_edit')}}</label>
    </div>
      <showcase-edit showcase-name="{{$showcase->name}}" showcase-id="{{$showcase->id}}"></showcase-edit>
    </div>
</div>

@endsection
