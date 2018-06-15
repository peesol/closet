{{Date::setLocale(App::getLocale())}}
<div class="panel-body">

    <p>
      <strong class="{{ $product->stock ? 'font-green' : 'font-red'}} font-15em">{{ $product->stock ? __('message.instock') : __('message.outstock')}}</strong><br>

      <span class="font-bold font-grey">{{__('message.price')}}</span>&nbsp;:&nbsp;
      @if($product->discount_price)
        <strike>{{ number_format($product->price) }}</strike>
        <small class="icon-next-arrow font-grey"></small>
        <font class="font-bold font-large font-green">{{ number_format($product->discount_price) }}&nbsp;{{__('message.baht')}}</font><br>
        <i>*{{__('message.discount_until')}}&nbsp;{{ Date::parse($product->discount_date)->diffForHumans() }}</i>
      @else
        <font class="font-bold font-large">{{ number_format($product->price) }}</font>&nbsp;{{__('message.baht')}}
      @endif
    </p>
    <label class="full-label {{ $product->shipping_free ? 'font-green' : 'not-display'}}">
      <span class="icon-truck"></span>&nbsp;{{__('message.free_shipping')}}
    </label>
    <label class="full-label input-label font-bold">{{__('message.shipping')}}</label>
    @foreach ( json_decode($product->shop->shipping) as $item)
      <li class="list-no-style">{{$item->method}}&nbsp;{{__('message.shipping_time')}}&nbsp;{{$item->time}}&nbsp;{{__('message.days')}}
        <font class="{{ $item->free ? 'font-green font-bold' : ''}}">{{ $item->free ? __('message.free_shipping') : $item->fee . ' ' . __('message.baht') }}</font>
      </li>
    @endforeach
</div>
