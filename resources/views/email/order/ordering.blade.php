@component('mail::message')

#{{trans('message.from')}} : {{ $order->sender }}
{{__('message.ordering_body')}}

@component('mail::table')
| {{__('message.product_name')}}| {{__('message.choice')}} | {{__('message.price')}}  | {{__('message.qty')}}  |
| :-------------|:-------------:| --------:| --------:|
@foreach(json_decode($order->body) as $item)
| {{$item->name}} | {{$item->options->choice}} | {{number_format($item->price)}} | {{$item->qty}} |
@endforeach
| |
@endcomponent
@component('mail::panel')
**{{__('message.total')}} {{number_format($order->total)}} {{__('message.baht')}}**
@if($order->discount)
*{{__('message.discount')}} {{$order->discount}}*
@endif
@endcomponent
##{{__('message.confirm_order')}}

@component('mail::button', ['url' => url('/order/'. $order->uid . '/confirm')])

    Click

@endcomponent

###{{__("message.alt_confirm")}}

@component('mail::subcopy')

- {{__('message.confirm_notice')}}
- {{__('message.shipping_fee_notice')}}
- {{__('message.order_deny')}}
- {{__('message.order_deny_notice')}}

@endcomponent


@endcomponent
