<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{__('message.shipped_confirm').' - Closet' }}</title>
    <link href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/main.css" rel="stylesheet">
    <script>
window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};

window.Closet = {
    url:'{{ config('app.url') }}',
    locale:'{{ App::getLocale() }}',
        user:{
            user: {{ Auth::check() ? Auth::user()->id : 'null' }},
            authenticated: {{ Auth::check() ? 'true':'false'}},
        }
    };
    </script>
</head>
<body>
        <div class="padding-30-vertical">
          @if(!$order->shipped)
          <div class="small-panel">
            <div class="panel-heading">
              <label class="heading">{{__('message.shipped_confirm')}}</label>
            </div>
            <div class="inbox-wrap panel-body">
              <h4>{{__('message.to')}}&nbsp;:&nbsp;{{$order->sender}}</h4>
              {{__('message.ordering_body')}}
              <div class="overflow-x-auto">
                <table class="c-table margin-10-top">
                  <tr>
                    <th class="overflow-hidden">{{__('message.product_name')}}</th>
                    <th>{{__('message.choice')}}</th>
                    <th>{{__('message.price')}}</th>
                    <th>{{__('message.qty')}}</th>
                  </tr>
                  @foreach(json_decode($order->body) as $item)
                  <tr>
                    <td class="overflow-hidden m-cell">{{$item->name}}</td>
                    <td class="m-cell">{{$item->options->choice ? $item->options->choice : '---'}}</td>
                    <td class="s-cell">{{$item->price}}</td>
                    <td class="s-cell">{{$item->qty}}</td>
                  </tr>
                  @endforeach
                </table>
              </div>
              
              @foreach (json_decode($order->shipping) as $shipping)
                <div class="form-group">
                  {{__('message.total')}} {{ $order->subtotal }} ฿
                  @if($order->discount)
                  ({{__('message.discount')}} {{$order->discount}})
                  @endif
                </div>
                <div class="form-group">
                  {{__('message.shipping_fee')}} {{ $shipping->free ? __('message.free_shipping') : $order->fee.' ฿' }}<br>
                  {{__('message.shipping')}} {{ $shipping->method }} {{ __('message.shipping_time') . ' ' . $shipping->time . ' ' . __('message.days')}}<br>
                  <small>{{ $shipping->multiply ? ' +' . $shipping->multiply_by . ' ฿ ' . __('message.shipping_multiply') : null }}</small><br>
                </div>
                <strong class="font-green font-large">{{__('message.total_price')}} {{ $order->total }}&nbsp;฿</strong>
              @endforeach

              <h4 class="font-red">*{{__('message.transaction_notice')}}</h4>
              <form method="post" action="/order/{{$order->uid}}/shipped_email">
                <div class="form-group">
                  <label class="full-width font-15em">{{__('message.shipped_carrier')}}</label>
                  <input required class="half-width-res form-input" name="carrier">
                </div>
                <div class="form-group">
                  <label class="full-width font-15em">{{__('message.shipped_track')}}</label>
                  <input required class="half-width-res form-input" name="tracking_number">
                </div>
                <div class="align-center padding-30-top">
                  <button class="half-width-res padding-10 orange-btn" type="submit">{{__('message.confirm')}}</button>
                </div>
              {{ csrf_field() }}
              {{ method_field('PUT') }}
              </form>
            </div>
          </div>
          @else
            <div style="margin-top:50px;">
              <div class="medium-panel">
                <div class="panel-body align-center">
                  <h3 class="font-green">{{__('message.already_confirmed')}}</h3>
                </div>
              </div>
            </div>
          @endif
        </div>
</body>
</html>
