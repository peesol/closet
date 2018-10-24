@component('mail::message')

#{{trans('message.from')}} : {{ $order->sender }}
Email : {{ $sender->email }}<br>
{{ __('message.phone')}} : {{ $sender->phone }}<br>
{{__('message.ordering_body')}}

@component('mail::table')
| {{__('message.product_name')}}| {{__('message.choice')}} | {{__('message.price')}}  | {{__('message.qty')}}  |
| :-------------|:-------------:| --------:| --------:|
@foreach($order->body as $item)
  | {{$item['name']}} | {{$item['options']['choice']}} | {{number_format($item['price'])}} | {{$item['qty']}} |
@endforeach
@endcomponent

@component('mail::panel')

  {{__('message.total')}} {{ $order->subtotal }} ฿
  @if($order->discount)
  ({{__('message.discount')}} {{$order->discount}})
  @endif
  <br>
  {{__('message.shipping_fee')}} {{ $order->shipping['free'] ? __('message.free_shipping') : $order->fee . ' ฿' }}<br>
  {{__('message.shipping')}} {{ $order->shipping['method'] }} {{ __('message.shipping_time') . ' ' . $order->shipping['time'] . ' ' . __('message.days.days')}}<br>
  @if($order->shipping['multiply'])
    {{ ' +' . $order->shipping['multiply_by'] . ' ฿ ' . __('message.shipping_multiply')}}<br>
  @endif
  #{{__('message.total_price')}} {{ $order->total }} ฿

  {{__('message.address')}}<br>
  {{ $order->address }}<br>

@endcomponent

#{{__('message.deniable_order')}}
@component('mail::button', ['url' => url('/order/'. $order->uid . '/deny_email')])

    Click

@endcomponent
###{{__('message.deniable_order_alt')}}

@endcomponent
