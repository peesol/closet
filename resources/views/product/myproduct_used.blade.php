@extends('layouts.app')
@section('title')
{{__('message.my_product').' - '}}
@endsection
@section('content')

<div class="container">
            <div class="large-panel">
                <div class="panel-heading">
                  <label class="full-label heading">{{__('message.my_product')}}</label>
                </div>
                <div class="tab-nav">
                    <ul class="tab-nav-ul">
                      <button class="tab-nav-btn static" onclick='document.location.href="/profile/myproduct/new"'>{{__('message.new')}}</button>
                      <button class="tab-nav-btn static current">{{__('message.used')}}</button>
                    </ul>
                </div>

                {{ $products->links() }}

                <div class="panel-body thumbnail-grid">
                  @include('thumbnail.myproducts._used')
                </div>

                {{ $products->links() }}

            </div>
</div>
@endsection
