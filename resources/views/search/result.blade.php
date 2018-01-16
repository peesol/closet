@extends('layouts.app')
@section('title')
{{$keyword.' - '}}
@endsection
@section('content')

<div class="container">
            <div class="large-panel">
                <div class="panel-heading"><p class="no-margin" style="font-weight: 600;">{{__('message.search_result')}} {{$keyword}}</p></div>

                <div class="filter">
                  <router-view>
                  </router-view>
                </div>

                <div class="panel-body thumbnail-grid">

                    @if ($products->count())

                    	@foreach ($products as $product)

                            @include('search.partials._product_result',[

                            	'product' => $product

                            ])

                    	@endforeach

                    @else

                    <p>{{__('message.search_no_match')}}</p>

                    @endif

                  <div style="width: 100%; padding: 15px 0px;">{{ $products->appends(request()->query())->links() }}</div>

                </div>
            </div>
</div>

@endsection


@section('scripts')

<script>
 $(document).ready(function() {
  $('#cat-btn').click(function() {
    $('#cat-option').toggleClass('filter-open');
    $('#price-option').removeClass('filter-open');
  });
  $('#price-btn').click(function() {
    $('#cat-option').removeClass('filter-open');
    $('#price-option').toggleClass('filter-open');
  });
});
</script>
@endsection
