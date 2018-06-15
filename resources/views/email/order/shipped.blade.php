@component('mail::message')

#{{trans('message.from')}} : {{ $order->reciever }}

{{__('message.shipped_body')}}<br>

@component('mail::panel')
{{__('message.shipped_carrier').' '. $order->carrier }}<br>
{{__('message.shipped_track')}} {{ $order->tracking_number ? $order->tracking_number : __('message.not_defined')}}<br>
## {{__('message.address')}}
{{ $order->address }}
@endcomponent


@component('mail::table')
| {{__('message.product_name')}}| {{__('message.choice')}} | {{__('message.price')}}  | {{__('message.qty')}}  |
| :-------------|:-------------:| --------:| --------:|
@foreach(json_decode($order->body) as $item)
| {{$item->name}} | {{$item->options->choice}} | {{number_format($item->price)}} | {{$item->qty}} |
@endforeach
|  |
@endcomponent

@component('mail::panel')

**{{__('message.total')}} {{number_format($order->total)}} {{__('message.baht')}}**
@if($order->discount)
*{{__('message.discount')}} {{$order->discount}}*
@endif

@foreach (json_decode($order->shipping) as $shipping)
### {{__('message.shipping_fee')}} : {{ $shipping->free ? __('message.free_shipping') : number_format($shipping->fee).' '.__('message.baht') }}
### {{__('message.shipping')}} {{ $shipping->method }} {{ __('message.shipping_time') . ' ' . $shipping->time . ' ' . __('message.days')}}
#{{__('message.total_price')}} {{number_format($order->total)}} {{__('message.baht')}}
@endforeach

@endcomponent


@component('mail::subcopy')

- {{__('message.shipped_warning')}}
- {{__('message.confirm_transaction_warning')}}

@endcomponent


@endcomponent
