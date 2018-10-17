@extends('layouts.app')

@section('title')
{{__('message.shipping_edit').' - '}}
@endsection

@section('content')

<div class="container">
  <div class="small-panel">
    <div class="panel-heading">
      <label class="full-label heading">{{__('message.shipping_edit')}}</label>
    </div>
      {{-- <div class="alert-box info">
        <label class="full-label input-label"><i class="fas fa-exclamation-circle"></i>&nbsp;{{__('message.shipping_edit_notice')}}</label>
      </div> --}}
      <shipping-edit :shipping="{{ $shipping }}" :days="{{ $days }}"></shipping-edit>

  </div>
</div>

@endsection
