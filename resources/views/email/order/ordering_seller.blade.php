@component('mail::message')

#{{trans('message.from')}} : {{ $order->sender }}
Email : {{ $sender->email }}<br>
{{ __('message.phone')}} : {{ $sender->phone }}<br>
{{__('message.ordering_body')}}

@component('mail::table')
| {{__('message.product_name')}}| {{__('message.choice')}} | {{__('message.price')}}  | {{__('message.qty')}}  |
| :-------------|:-------------:| --------:| --------:|
@foreach(json_decode($order->body) as $item)
| {{$item->name}} | {{$item->options->choice}} | {{number_format($item->price)}} | {{$item->qty}} |
@endforeach
@endcomponent

@component('mail::panel')
  @foreach (json_decode($order->shipping) as $shipping)
  {{__('message.total')}} {{ $order->subtotal }} ฿
  @if($order->discount)
  ({{__('message.discount')}} {{$order->discount}})
  @endif
  <br>
  {{__('message.shipping_fee')}} {{ $shipping->free ? __('message.free_shipping') : $order->fee . ' ฿' }}<br>
  {{__('message.shipping')}} {{ $shipping->method }} {{ __('message.shipping_time') . ' ' . $shipping->time . ' ' . __('message.days')}}<br>
  {{ $shipping->multiply ? ' +' . $shipping->multiply_by . ' ฿ ' . __('message.shipping_multiply') : null }}<br>
  #{{__('message.total_price')}} {{ $order->total }} ฿
  @endforeach

{{__('message.address')}}<br>
{{ $order->address }}<br>

@endcomponent

#{{__('message.deniable_order')}}
@component('mail::button', ['url' => url('/order/'. $order->uid . '/deny_email')])

    Click

@endcomponent
###{{__('message.deniable_order_alt')}}

@endcomponent
