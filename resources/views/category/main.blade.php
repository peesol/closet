@extends('layouts.app')
@section('title')
{{__('message.category').' - '}}
@endsection
@section('css')
<link href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/extra/slick-theme.css" rel="stylesheet">
<link href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/extra/slick.css" rel="stylesheet">
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script>
window.addEventListener('load', function () {
  document.querySelector('.category-nav-btn').addEventListener('click', function () {
     this.classList.toggle('clicked');
     document.querySelector('.category-nav').classList.toggle('category-opened');
  });
})
</script>
@endsection

@section('content')

<div class="container">
  <div class="large-panel">
                <div id="full-line">
                  <button class="category-nav-btn">{{__('message.category')}}&nbsp;<small>▼</small></button>
                </div>
                <div class="category-nav">
                  @foreach ($categories as $category)
                    <a href="/category/{{$category->slug}}">{{$category->showTranslate(App::getLocale())->name}}</a>
                  @endforeach
                </div>
                @foreach ($categories as $category)
                @if($category->product->count())
                <div class="panel-heading">
                  <h3 class="no-margin">{{$category->showTranslate(App::getLocale())->name}}</h3>
                </div>
                <div class="category-carousel">
                  <vue-slick :products="{{ $category->product()->popular()->take(10)->get() }}" path="/product/thumbnail/" slick-for="category"></vue-slick>
                </div>
                @endif
                @endforeach
  </div>
</div>
@endsection
