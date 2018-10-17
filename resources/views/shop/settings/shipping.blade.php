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
      <div class="relative">
        <load-overlay bg="white-bg" :show="$root.loading" padding="60px 0"></load-overlay>
        <shipping-edit :shipping="{{ $shipping }}"></shipping-edit>
      </div>
  </div>
</div>

@endsection
