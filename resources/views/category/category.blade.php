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
	$(document).ready(function() {
	   $('.category-nav-btn').click(function(e) {
	     e.preventDefault();
	     $('.category-nav').toggleClass('category-opened');
	     $('.category-nav-btn').toggleClass('clicked');
	   });
	});
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
                <div class="no-border-heading">
                <h3 class="no-margin">{{ $subcategory->showTranslate(App::getLocale())->name }}</h3>
                </div>

                  <div class="category-carousel">
                    @foreach($subcategory->product()->popular()->take(10)->get() as $product)
                        <div class="category-p-img">
                                <a href="/product/{{ $product->uid}}">
                                <img class="products-img-thumb" src="{{config('closet.buckets.images') . '/product/thumbnail/' . $product->thumbnail}}"
                                alt="{{$product->thumbnail}} image">
                                <h3 class="category-p-name no-margin"><a href="/product/{{ $product->uid}}">{{ $product->name }}</a></h3>
                                <p class="category-p-price no-margin">{{ $product->price }}</p>
                                </a>
                        </div>
                    @endforeach
                  </div>

                  @else

                  @endif
                @endforeach
            </div>
</div>
<script>
$('.category-carousel').slick({
  infinite: false,
  speed: 300,
  slidesToShow: 6,
  slidesToScroll: 6,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 4,
        infinite: false,
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});
</script>
@endsection
