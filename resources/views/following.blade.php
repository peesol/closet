@extends('layouts.app')

@section('title')
{{__('message.following').' - '}}
@endsection

@section('content')

<div class="container">
  <div class="large-panel">
    <div class="panel-heading">
      <label class="heading">{{__('message.following')}}</label>
    </div>

      @foreach($followingShop as $shop)

      <div class="panel-body">
        <a href="/{{ $shop->slug }}">
          <img src="{{ $shop->getThumbnail() }}" alt="{{ $shop->thumbnail }}" class="float-left margin-20-right user-thumbnail">
        </a>

        <div class="flex-column flex">
          <a class="font-15em text-nowrap" href="/{{ $shop->slug }}">{{ $shop->name }}</a>
          <p class="text-nowrap">{{ $shop->description }}</p>
          <div class="align-right">
            <form class="width-120-res float-right" action="{{route('unfollow')}}" method="post">
              <input type="hidden" name="shop_id" value="{{ $shop->id }}">
              <button type="submit" class="follow-btn unfollow" onclick="if(!confirm('{{ __('message.form_confirm') }}')) { return false; }">{{ __('message.unfollow') }}</button>
              @csrf
              @method('DELETE')
            </form>
          </div>

        </div>

      </div>

      @endforeach

  </div>
</div>

@endsection
