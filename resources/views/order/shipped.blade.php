<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{__('message.shipped_confirm').' - Closet' }}</title>
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
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
  <div style="margin:20px;">
        <div class="container">
          @if(!$order->shipped)
          <div class="listing-panel">
            <div class="panel-heading">
              <h3 class="no-margin">{{__('message.shipped_confirm')}}</h3>
            </div>
            <div class="inbox-wrap panel-body">
              <h4>{{__('message.to')}}&nbsp;:&nbsp;{{$order->sender}}</h4>
              {{__('message.ordering_body')}}
              <table class="c-table margin-top-10px">
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
                <tr>
                  <td colspan="4" class="no-border">{{__('message.total')}}&nbsp;:&nbsp;<span style="font-weight:600;">{{ number_format($order->total).' '.__('message.baht') }}</span></td>
                </tr>
                <tr>
                  <td colspan="4" class="no-border">{{__('message.shipping_fee')}}&nbsp;:&nbsp;
                    @if($order->shipping_fee !== null)
                    <span class="font-bold">{{number_format($order->shipping_fee).' '.__('message.baht')}}</span>
                    @else
                    <span class="font-bold green-font">{{__('message.free_shipping')}}</span>
                    @endif
                  </td>
                </tr>
                <tr>
                  <td colspan="4"><h4 class="no-margin">{{__('message.total_price')}}&nbsp;:&nbsp;<span style="color:#4aae2a; font-weight:600;">{{number_format($order->total + $order->shipping_fee)}}</span>&nbsp;{{__('message.baht')}}</h4></td>
                </tr>
              </table>
              <h4 class="red-font">*{{__('message.transaction_notice')}}</h4>
              <form method="post" action="/order/{{$order->uid}}/shipped_email">
                <div class="form-group">
                  <label class="col-label" style="width:100%;">{{__('message.shipped_carrier')}}</label>
                  <input required class="col-input" name="carrier">
                </div>
                <div class="form-group">
                  <label class="col-label" style="width:100%;">{{__('message.shipped_track')}}</label>
                  <input required class="col-input" name="tracking_number">
                </div>
              <div class="flex msg-btn margin-top-10px">
                <button type="submit">{{__('message.confirm')}}</button>
              </div>
              {{ csrf_field() }}
              {{ method_field('PUT') }}
              </form>
            </div>
          </div>
          @else
          <div style="margin-top:50px;">
            <div class="shop-panel">
              <div class="panel-body">
                <h3 class="green-font">{{__('message.already_confirmed')}}</h3>
              </div>
            </div>
          </div>
          @endif
        </div>
      </div>
</body>
</html>
