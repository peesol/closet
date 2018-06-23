<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <!-- Styles -->
    <link href="https://s3-ap-southeast-1.amazonaws.com/files.closet/css/main.css" rel="stylesheet">
</head>
<body>
<div class="container margin-30-top">
  <div class="medium-panel">
    <div class="panel-body">
      <h3 class="font-red">{{__('message.order_deleted')}}</h3>
    </div>
  </div>
</div>
</body>
</html>
