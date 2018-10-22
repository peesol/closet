@component('mail::message')

# {{trans('message.from')}} : {{ $order->reciever }}
## {{__('message.denied_reason')}}
{{ $reason }}

@component('mail::table')
| {{__('message.product_name')}}| {{__('message.choice')}} | {{__('message.price')}}  | {{__('message.qty')}}  |
| :-------------|:-------------:| --------:| --------:|
@foreach($order->body as $item)
  | {{$item['name']}} | {{$item['options']['choice']}} | {{number_format($item['price'])}} | {{$item['qty']}} |
@endforeach
|  |
@endcomponent

@component('mail::panel')

  {{__('message.total')}} {{ $order->subtotal }} ฿
  @if($order->discount)
  ({{__('message.discount')}} {{$order->discount}})
  @endif
  <br>
  {{__('message.shipping_fee')}} {{ $order->shipping['free'] ? __('message.free_shipping') : $order->fee . ' ฿' }}<br>
  {{__('message.shipping')}} {{ $order->shipping['method'] }} {{ __('message.shipping_time') . ' ' . $order->shipping['time'] . ' ' . __('message.days.days')}}<br>
  {{ $order->shipping['multiply'] ? ' +' . $order->shipping['multiply_by'] . ' ฿ ' . __('message.shipping_multiply') : null }}<br>
  #{{__('message.total_price')}} {{ $order->total }} ฿

@endcomponent

@component('mail::subcopy')

- {{__('message.denied_subcopy')}}
- {{__('message.confirm_transaction_warning')}}

@endcomponent


@endcomponent
