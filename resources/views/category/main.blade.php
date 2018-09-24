@extends('layouts.app')
@section('title')
{{__('message.category').' - '}}
@endsection
@section('scripts')
<script>
window.addEventListener('load', function () {
  document.querySelector('.category-nav-btn').addEventListener('click', function () {
    console.log('CLICKED');
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
      <button class="orange-btn normal-sq category-nav-btn">{{__('message.category')}}&nbsp;<i class="fas fa-chevron-down"></i></button>

      <div class="filter margin-20-top not-display">
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
