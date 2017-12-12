@extends('layouts.app')

@section('content')

<div class="container">
            <div class="large-panel">
                <div class="panel-heading margin-bot-10px">Dashboard</div>
                <div class="panel-body flex">
                @if ($product->count())
                @foreach( $product as $products)
                    <p>{{ $product->product_name }} </p>
                @endforeach
                @endif
                </div>
            </div>
</div>

@endsection