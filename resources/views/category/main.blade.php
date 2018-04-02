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
     document.querySelector('.filter').classList.toggle('display');
  });
})
</script>
@endsection

@section('content')

<div class="container">
  <div class="large-panel">
    <div class="panel-body">
      <button class="orange-btn normal-sq category-nav-btn">{{__('message.category')}}&nbsp;<small class="icon-arrow-down"></small></button>

      <div class="filter margin-20-top" style="display:none">
        <div class="categories">
          <ul>
            @foreach ($categories as $category)
              <li><a href="/category/{{$category->slug}}">{{$category->showTranslate(App::getLocale())->name}}</a></li>
            @endforeach
          </ul>
        </div>
      </div>

    </div>

                @foreach ($categories as $category)
                @if($category->product->count())
                  <div class="panel-body">
                    <div class="padding-15-bottom">
                      <a href="/category/{{$category->slug}}" class="font-15em flat-btn">{{$category->showTranslate(App::getLocale())->name}}&nbsp;</a>
                    </div>
                    <div class="category-carousel">
                      <vue-slick :products="{{ $category->product()->popular()->take(10)->get() }}" path="/product/thumbnail/" slick-for="category"></vue-slick>
                    </div>
                  </div>
                @endif
                @endforeach
  </div>
</div>
@endsection
