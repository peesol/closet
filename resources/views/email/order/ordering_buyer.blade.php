@component('mail::message')

#{{trans('message.from')}} : {{ $order->reciever }}
{{__('message.confirmed_body')}}

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

{{__('message.address')}}<br>
{{ $order->address }}<br>

@endcomponent

##{{__('message.confirm_transaction')}}

@component('mail::table')
| {{__('message.provider')}}| {{__('message.account_number')}} | {{__('message.account_name')}}  |
| :-------------|:-------------:| --------:|
@foreach($accounts as $account)
| {{$account->provider_name}} | {{$account->number}} | {{$account->name}} |
@endforeach

@endcomponent

#{{__('message.transacted')}}

@component('mail::button', ['url' => url('/order/'. $order->uid . '/transaction_email')])

    Click

@endcomponent

###{{__("message.transacted_alt")}}

#{{__('message.cancleable_order')}}
@component('mail::button', ['url' => url('/order/'. $order->uid . '/cancle_email')])

    Click

@endcomponent
###{{__('message.cancleable_order_alt')}}

@component('mail::subcopy')

- {{__('message.confirm_transaction_notice')}}
- {{__('message.confirm_transaction_warning')}}

@endcomponent


@endcomponent
