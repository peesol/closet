@extends('layouts.app')

@section('title')
{{__('message.category').' - '}}
@endsection

@section('content')

<div class="container">
            <div class="large-panel">
                <div>
                  <button class="category-nav-btn">{{__('message.category')}}&nbsp;<small>▼</small></button>
                  <div id="full-line"></div>
                </div>
                <div class="category-nav">
                        @foreach ($categories as $category)
                        <a href="/category/{{$category->name}}">{{$category->showTranslate(App::getLocale())->name}}</a>
                        @endforeach
                </div>
                @foreach ($categories as $category)
                @if($category->product->count())
                <div class="no-border-heading">
                <h3 class="no-margin">{{$category->showTranslate(App::getLocale())->name}}</h3>
                </div>
                  <div class="category-carousel">
                    @foreach($category->product()->popular()->take(10)->get() as $product)
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

@section('css')
<link href="{{ asset('css/slick-theme.css') }}" rel="stylesheet">
<link href="{{ asset('css/slick.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script type="text/javascript" src="{{asset('js/slick.min.js')}}"></script>
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
