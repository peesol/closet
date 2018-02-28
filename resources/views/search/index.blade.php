@extends('layouts.app')
@section('title')
{{$keyword.' - '}}
@endsection
@section('content')

<div class="container">
            <div class="large-panel">
                <div class="panel-heading"><p class="no-margin" style="font-weight: 600;">{{__('message.search_result')}} {{$keyword}}</p></div>

                <router-view>
                </router-view>
            </div>
</div>

@endsection
