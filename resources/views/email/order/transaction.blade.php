@component('mail::message')

#{{trans('message.transaction_subject')}} : {{ $order->sender }}
{{__('message.transaction_head')}}

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
### {{__('message.shipping_fee')}} : {{$order->shipping_fee ? number_format($order->shipping_fee).' '.__('message.baht') : __('message.free_shipping') }}
#{{__('message.total_price')}} {{number_format($order->total + $order->shipping_fee)}} {{__('message.baht')}}

@endcomponent

##{{__('message.date_recieved').' '.$data['date']}} {{__('message.time_recieved').' '.$data['time']}}
{{__('message.name').' '.$data['name']}}<br>
{{__('message.address')}}<br>
{{$data['address']}}<br>
{{__('message.phone').' '.$data['phone']}}

##{{__('message.confirm_deliver')}}
@component('mail::button', ['url' => url('/order/'. $order->uid . '/shipped_email')])

    Click

@endcomponent

###{{__("message.alt_confirm_deliver")}}

@endcomponent
