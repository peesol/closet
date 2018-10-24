@component('mail::message')

#{{trans('message.from')}} : {{ $order->reciever }}
{{__('message.confirmed_body')}}

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

##{{__('message.confirm_transaction')}}

@component('mail::table')
| {{__('message.provider')}}| {{__('message.account_number')}} | {{__('message.account_name')}}  |
| :-------------|:-------------:| --------:|
@foreach($accounts as $account)
| {{$account->provider_name}} {{$account->type == 'PromptPay' ? __('message.promptpay') : null}} | {{$account->number}} | {{$account->name}} |
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
