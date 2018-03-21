@extends('layouts.app')
@section('title')
{{$keyword.' - '}}
@endsection
@section('content')

<div class="container">
            <div class="large-panel">
                <div class="panel-heading">
                  <label class="full-label heading">{{__('message.search_result')}} {{$keyword}}</label>
                </div>

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
