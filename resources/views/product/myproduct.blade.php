@extends('layouts.app')
@section('title')
{{__('message.my_product').' - '}}
@endsection
@section('content')

<div class="container">
            <div class="large-panel">
                <div class="panel-heading"><h3 class="no-margin">{{__('message.my_product')}}</h3></div>
                <div class="tab-nav" style="border: none;">
                    <ul class="tab-nav-ul" style="border-top: none; border-bottom: 1px solid #efefef;">
                      <button class="tab-nav-btn static current">{{__('message.new')}}</button>
                      <button class="tab-nav-btn static" onclick='document.location.href="/profile/myproduct/used"'>{{__('message.used')}}</button>
                    </ul>
                </div>
                @if ($products->count())
                <div class="panel-heading margin-10-top">
                  <button class="orange-btn normal-sq" onclick='document.location.href="/profile/myproduct/stock"'>{{__('message.stock_edit')}}</button>
                  <button class="orange-btn normal-sq margin-20-left" onclick='document.location.href="/profile/myproduct/shipping"'>{{__('message.shipping_edit')}}</button>
                </div>
                @endif

                @if(count($products) > 10)
                <div class="pagination-wrap">{{ $products->links() }}</div>
                @endif

                <div class="panel-body thumbnail-grid">
                  @include('thumbnail.myproducts._new')
                </div>

                @if(count($products) > 10)
                  <div class="pagination-wrap">{{ $products->links() }}</div>
                @endif
            </div>
</div>
<script>
    $(".delete-btn").click(function() {
            if(confirm('Are you sure you want to delete this?')){
                return true;
            }
            return false;
        });
</script>
@endsection
