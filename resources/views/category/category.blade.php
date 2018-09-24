@extends('layouts.app')
@section('title')
{{$category->showTranslate(App::getLocale())->name.' - '}}
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
              <div class="panel-heading">
                <label class="heading">{{$category->showTranslate(App::getLocale())->name}}</label>
              </div>
              <div class="panel-body">
                <button class="orange-btn normal-sq category-nav-btn">{{__('message.category')}}&nbsp;<i class="fas fa-chevron-down"></i></button>

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

                @foreach ($subcategories as $subcategory)
                  @if($subcategory->product->count())
                    <div class="panel-body">
                      <div class="padding-15-bottom">
                        <label class="heading">{{$subcategory->showTranslate(App::getLocale())->name}}&nbsp;</label>
                      </div>
                      <div class="category-carousel">
                        <vue-slick :products="{{ $subcategory->product()->popular()->take(10)->get() }}" path="/product/thumbnail/" slick-for="category"></vue-slick>
                      </div>
                    </div>
                  @endif
                @endforeach
            </div>
</div>
@endsection
