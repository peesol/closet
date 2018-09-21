{{-- THIS VIEW HAS BEEN DEACTIVATED SINCE WE DONT HAVE TO CONFIRM --}}

<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{__('message.confirmation').' - Closet' }}</title>
    <!-- Styles -->
    <link href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/main.css" rel="stylesheet">
    <!-- Scripts -->
    <script src="https://s3-ap-southeast-1.amazonaws.com/files.closet/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.0.9/cleave.min.js"></script>
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
  @if(!$order->confirmed)
  <div class="small-panel">
    <div class="panel-heading">
      <label class="heading">{{__('message.confirmation')}}</label>
    </div>
    <div class="inbox-wrap panel-body">
      <h4>{{__('message.from')}}&nbsp;:&nbsp;{{$order->sender}}</h4>
      {{__('message.ordering_body')}}
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
      <confirm-selling uid="{{$order->uid}}" locale="{{App::getLocale()}}"></confirm-selling>
    </div>
  </div>
  @else
  <div class="medium-panel">
    <div class="panel-body">
      <h3 class="font-green">{{__('message.already_confirmed')}}</h3>
    </div>
  </div>
  @endif
</div>

</div>
<script>

window.addEventListener('load', function () {
    var list = new Vue({
      el: '.container',
    });
});
</script>

</body>
</html>
