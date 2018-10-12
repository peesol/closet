@extends('layouts.app')
@section('title')
{{__('message.my_product').' - '}}
@endsection
@section('content')
<div class="container">
            <div class="large-panel">
                <div class="panel-heading">
                  <label class="heading">{{__('message.my_product')}}</label>
                </div>
                {{-- <div class="tab-nav">
                    <ul class="tab-nav-ul">
                      <button class="tab-nav-btn static current">{{__('message.new')}}</button>
                      <button class="tab-nav-btn static" onclick='document.location.href="/myproduct/used"'>{{__('message.used')}}</button>
                    </ul>
                </div> --}}
                @if ($products->count())
                <div class="panel-heading">
                  <button class="orange-btn normal-sq" onclick='document.location.href="/myproduct/stock"'>{{__('message.stock_edit')}}</button>
                  <button class="orange-btn normal-sq margin-20-left" onclick='document.location.href="/myproduct/shipping"'>{{__('message.shipping_edit')}}</button>
                </div>
                @endif

                {{ $products->links() }}

                <div class="panel-body {{$products->count() ? 'thumbnail-grid' : 'align-center'}}">
                  @include('thumbnail.myproducts._new')
                </div>

                {{ $products->links() }}

            </div>
</div>
@endsection
