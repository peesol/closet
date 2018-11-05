{{Date::setLocale(App::getLocale())}}
<div class="padding-15-bottom padding-15-horizontal">
    <p>
      <strong class="{{ $product->stock ? 'font-green' : 'font-red'}} font-15em">{{ $product->stock ? __('message.instock') : __('message.outstock')}}</strong><br>
      <span class="font-bold font-grey">{{__('message.price')}}</span>&nbsp;:&nbsp;
      @if($product->discount_price)
        <s>{{ number_format($product->price) }}</s>
        <font class="font-bold font-large font-green">{{ number_format($product->discount_price) }}&nbsp;฿</font><br>
        <i>*{{__('message.discount_until')}}&nbsp;{{ Date::parse($product->discount_date)->diffForHumans() }}</i>
      @else
        <font class="font-bold font-large">{{ number_format($product->price) }}</font>&nbsp;฿
      @endif
      <br>
      @if ($shippingPromotion)
        @foreach ($shippingPromotion as $promotion)
          @if ($promotion['type'] == 'cost')
            <span class="font-green">{{ __('message.shipping_promotion.title', ['type' => __('message.shipping_promotion.spend')]) }}&nbsp;{{ $promotion['amount'] }}&nbsp;{{ __('message.shipping_promotion.cost') }}</span>
          @else
            <span class="font-green">{{ __('message.shipping_promotion.title', ['type' => __('message.shipping_promotion.buy')]) }}&nbsp;{{ $promotion['amount'] }}&nbsp;{{ __('message.shipping_promotion.qty') }}</span>
          @endif
        @endforeach
      @endif
    </p>
    <label class="input-label font-bold">{{__('message.days.title')}}</label>
    @foreach ($shippingDate as $day)
      <font class="arial">
        {{ $day }}
      </font>
    @endforeach

    <label class="full-label {{ $product->shipping_free ? 'font-green' : 'not-display'}}">
      <span class="fas fa-truck"></span>&nbsp;{{__('message.free_shipping')}}
    </label>
    <label class="full-label input-label font-bold">{{__('message.shipping')}}</label>
    @foreach ( $shipping as $item)
      <div class="padding-5">{{$item->method}}&nbsp;{{__('message.shipping_time')}}&nbsp;{{$item->time}}&nbsp;{{__('message.days.days')}}
        <font class="{{ $item->free ? 'font-green font-bold' : ''}}">{{ $item->free ? __('message.free_shipping') : $item->fee . ' ฿' }}</font><br>
        <small>{{ $item->multiply ? ' +' . $item->multiply_by . ' ฿ ' . __('message.shipping_multiply') : null }}</small>
      </div>
    @endforeach
</div>
