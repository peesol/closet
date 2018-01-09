@extends('layouts.app')
@section('title')
{{__('message.showcase_edit')}}
@endsection
@section('content')

<div class="container">
            <div class="shop-panel">
                <div class="panel-heading margin-bot-10px"><h3 class="no-margin">{{__('message.showcase_edit')}}</h3></div>
                <showcase-edit showcase-name="{{$showcase->name}}"
                  shop-slug="{{$shop->slug}}"
                  showcase-id="{{$showcase->id}}"></showcase-edit>
            </div>
</div>
<script>
window.addEventListener('load', function () {
      var showcase = new Vue({
        el: '.container'
      });
});
</script>
@endsection
