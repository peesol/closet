@component('mail::message')

#{{trans('message.from')}} : {{ $order->sender }}
{{ $contact }}
##{{__('message.cancled_subject')}}

@component('mail::table')
| {{__('message.product_name')}}| {{__('message.choice')}} | {{__('message.price')}}  | {{__('message.qty')}}  |
| :-------------|:-------------:| --------:| --------:|
@foreach(json_decode($order->body) as $item)
| {{$item->name}} | {{$item->options->choice}} | {{number_format($item->price)}} | {{$item->qty}} |
@endforeach
|  |
@endcomponent
@component('mail::panel')
@foreach (json_decode($order->shipping) as $shipping)
{{__('message.total')}} {{number_format($order->total)}} ฿
@if($order->discount)
({{__('message.discount')}} {{$order->discount}})
@endif
<br>
{{__('message.shipping_fee')}} {{ $shipping->free ? __('message.free_shipping') : number_format($shipping->fee).' ฿' }}<br>
{{__('message.shipping')}} {{ $shipping->method }} {{ __('message.shipping_time') . ' ' . $shipping->time . ' ' . __('message.days')}}<br>
#{{__('message.total_price')}} {{number_format($order->total + $shipping->fee)}} ฿
@endforeach
@endcomponent

@component('mail::subcopy')

- {{__('message.cancled_subcopy')}}
- {{__('message.confirm_transaction_warning')}}

@endcomponent


@endcomponent
