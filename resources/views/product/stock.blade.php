@extends('layouts.app')
@section('title')
{{__('message.stock_edit').' - '}}
@endsection
@section('content')

<div class="container">
            <div class="shop-panel">
                <product-stock></product-stock>
            </div>
</div>

@endsection
@section('scripts')
<script>
    window.addEventListener('load', function () {
        var follow = new Vue({
          el: '.container'
        });
    });
</script>
@endsection
