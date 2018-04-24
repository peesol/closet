<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>{{__('message.report_seller')}} - Closet</title>
    <!-- Styles -->
    <link href="{{asset('css/main.css')}}" rel="stylesheet">
    <script type="text/javascript">
      window.onbeforeunload = function() {
          return "Dude, are you sure you want to leave? Think of the kittens!";
      }
    </script>
  </head>
  <body>
    <div class="container margin-30-top">
      <div class="medium-panel">
        <div class="panel-heading-alt">
          <h2>{{__('message.report_seller')}}</h2>
        </div>
        <div class="panel-body-alt">
          <span class="font-bold"> {{__('message.seller')}}</span>&nbsp;{{ $shop->name }}<br>
          <div class="padding-30-vertical">
            <form action="{{ route('shopReport', $shop->slug) }}" method="post">
              {{ csrf_field() }}
              <div class="form-group">
                <label class="full-label input-label" for="title">{{__('message.report_title')}}</label>
                <input required class="form-input" name="title" type="text" id="title">
              </div>
              <div class="form-group">
                <label for="body" class="input-label">{{__('message.report_body')}}</label>
                <textarea required id="body" name="body" class="description-input" rows="8" cols="80"></textarea>
              </div>
              <div class="align-right padding-15-top">
                <button class="orange-btn normal-sq" type="submit">{{__('message.report_submit')}}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
