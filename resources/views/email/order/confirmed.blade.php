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
### {{__('message.shipping_fee')}} : {{$order->shipping_fee ? number_format($order->shipping_fee).' '.__('message.baht') : __('message.free_shipping') }}
#{{__('message.total_price')}} {{number_format($order->total + $order->shipping_fee)}} {{__('message.baht')}}

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

@component('mail::subcopy')

- {{__('message.confirm_transaction_notice')}}
- {{__('message.confirm_transaction_warning')}}

@endcomponent


@endcomponent
