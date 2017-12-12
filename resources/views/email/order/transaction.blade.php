<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Closet</title>
<style>
	html {
    font-family: Avenir, Helvetica, sans-serif;
    height: 100%;
    box-sizing: border-box;
	}
	body{
		background-color: #ffffff;
		margin:0;
	}
	.container{
    display: flex;
    justify-content: center;
		position: relative;
	}
  table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 20px;
  }
  @@media (min-width: 768px) {
    table{
      width: 80%;
    }
  }

  tr:first-child, tr:last-child{
    background-color: #ff8000 !important;
    color: #ffffff;
  }
  tr:nth-child(1n+2){
    border: none;
    background-color: #ffffff;
  }
  .product td:first-child {
    padding-left: 8px;
    max-width: 0;
    min-width: 150px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
  .product td {
    border-bottom: 1px solid #f2f2f2 !important;
  }
  td:first-child{
    padding: 0px 8px;

  }
  td:last-child {
    padding-right: 8px;
  }
  td {
    height: 30px;
  }
  td span.green{
    color: #4aae2a;
    font-weight: 600;
  }
  td span.grey{
    color: #6c6c6c;
    font-weight: 600;
  }
  td.grey-bg{
    background: #f7f7f7;
  }
  .logo{
    margin: 0 auto;
    display: table;
  }
  a {
    text-decoration: none;
    color: #0079bf;
  }
  h4 {
    margin: 0;
  }
  ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  li:before {
    content: "*";
    padding-right: 3px;
    color: red;
  }
  li {
    margin-bottom: 6px;
  }
</style>

</head>
<body>
  {{ \App::setLocale($locale)}}
<div class="container">
  <table>
    <tr>
      <td colspan="4" class="header"><img class="logo" src="{{asset("images/logo2.png")}}"></td>
    </tr>
    <tr>
      <td colspan="4"><h3>{{__('message.transaction_subject').' : '. $order->sender}}</h3></td>
    </tr>
    <tr>
      <td colspan="4"><p>{{__('message.transaction_head')}}</p></td>
    </tr>
    <tr class="product" style="background:#f2f2f2;">
      <td><h4>{{__('message.product_name')}}</h4></td>
      <td><h4>{{__('message.choice')}}</h4></td>
      <td><h4>{{__('message.price')}}</h4></td>
      <td><h4>{{__('message.qty')}}</h4></td>
    </tr>
    @foreach (json_decode($order->body) as $item)
    <tr class="product">
      <td>{{$item->name}}</td>
      <td>{{$item->options->choice}}</td>
      <td>{{$item->price}}</td>
      <td>{{$item->qty}}</td>
    </tr>
    @endforeach
    <tr>
      <td colspan="4">{{__('message.total')}}&nbsp;:&nbsp;<span style="font-weight:600;">{{ number_format($order->total).' '.__('message.baht') }}</span></td>
    </tr>
    <tr>
      <td colspan="4">{{__('message.shipping_fee')}}&nbsp;:&nbsp;
        @if($order->shipping_fee !== null)
        <span style="font-weight:600;" class="">{{number_format($order->shipping_fee).' '.__('message.baht')}}</span>
        @else
        <span style="color:#4aae2a; font-weight:600;">{{__('message.free_shipping')}}</span>
        @endif
      </td>
      <td colspan="2"></td>
    </tr>
    <tr class="product">
      <td colspan="4"><h4>{{__('message.total_price')}}&nbsp;:&nbsp;<span class="green">{{number_format($order->total + $order->shipping_fee)}}</span>&nbsp;{{__('message.baht')}}</h4></td>
    </tr>
    <tr>
      <td colspan="4"></td>
    </tr>
    <!-- Delivery Information -->
    <tr>
      <td colspan="4" class="grey-bg"><h4>{{__('message.date_recieved').' '.$data['date']}}&nbsp;{{__('message.time_recieved').' '.$data['time']}}</h4></td>
    </tr>
    <tr>
      <td colspan="4" class="grey-bg"><span class="grey">{{__('message.name')}}</span>&nbsp;{{$data['name']}}</td>
    </tr>
    <tr>
      <td colspan="4" class="grey-bg"><span class="grey">{{__('message.address')}}</span></td>
    </tr>
    <tr>
      <td colspan="4" class="grey-bg">{{$data['address']}}</td>
    </tr>
    <tr>
      <td colspan="4" class="grey-bg"><span class="grey">{{__('message.phone')}}</span>&nbsp;{{$data['phone']}}</td>
    </tr>
    <tr>
      <td colspan="4">
        <p style="font-size: 20px;">{{__('message.confirm_deliver')}}<a class="btn" href="{{url('/order/'. $order->uid . '/shipped_email')}}">&nbsp;Click</a></p>
        <p>{{__("message.alt_confirm_deliver")}}</p>
      </td>
    </tr>

    <tr>
      <td colspan="4"><h5>© {{ date('Y') }} {{config('app.name')}} All rights reserved.</h5></td>
    </tr>
  </table>
</div>
</body>
</html>
