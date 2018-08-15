<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>{{__('message.report_product')}} - Closet</title>
    <!-- Styles -->
    <link href="{{asset('css/main.css')}}" rel="stylesheet">
  </head>
  <body>
    <div class="container margin-30-top">
      <div class="medium-panel">
        <div class="panel-heading-alt">
          <h2>{{__('message.report')}}</h2>
        </div>
        <div class="panel-body-alt">
          <div class="padding-30-vertical">
            <form action="{{ route('askPost') }}" method="post">
              {{ csrf_field() }}
              <div class="form-group">
                <label class="full-label input-label" for="email">{{__('message.email')}}</label>
                <input required class="form-input" name="email" type="email" id="email">
              </div>
              <div class="form-group">
                <label class="full-label input-label" for="name">{{__('message.name')}}</label>
                <input required class="form-input" name="name" type="text" id="name">
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
