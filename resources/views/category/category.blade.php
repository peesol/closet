@extends('layouts.app')
@section('title')
{{$category->showTranslate(App::getLocale())->name.' - '}}
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
                <div>
                  <button class="category-nav-btn">{{__('message.category')}}&nbsp;<small>▼</small></button>
                  <div id="full-line"></div>
                </div>
                <div class="category-nav">
                    @foreach ($categories as $cat)
                      <a href="/category/{{$cat->slug}}">{{$cat->showTranslate(App::getLocale())->name}}</a>
                    @endforeach
                </div>

                <div class="panel-heading"><h3 class="no-margin">{{$category->showTranslate(App::getLocale())->name}}</h3></div>

                @foreach ($subcategories as $subcategory)
                  @if($subcategory->product->count())
                  <div class="panel-heading">
                    <h3 class="no-margin">{{ $subcategory->showTranslate(App::getLocale())->name }}</h3>
                  </div>

                  <div class="category-carousel">
                    <vue-slick :products="{{ $subcategory->product()->popular()->take(10)->get() }}" path="/product/thumbnail/" slick-for="category"></vue-slick>
                  </div>
                  @endif
                @endforeach
            </div>
</div>
@endsection
