@extends('layouts.app')
@section('title')
{{__('message.my_product').' - '}}
@endsection
@section('content')

<div class="container">
            <div class="large-panel">
                <div class="panel-heading"><h3 class="no-margin">{{__('message.my_product')}}</h3></div>
                <div class="tab-nav">
                    <ul class="tab-nav-ul">
                      <button class="tab-nav-btn static" onclick='document.location.href="/profile/myproduct/new"'>{{__('message.new')}}</button>
                      <button class="tab-nav-btn static current">{{__('message.used')}}</button>
                    </ul>
                </div>

                @if(count($products) > 10)
                <div class="pagination-wrap">{{ $products->links() }}</div>
                @endif

                <div class="panel-body thumbnail-grid">
                  @include('thumbnail.myproducts._used')
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
