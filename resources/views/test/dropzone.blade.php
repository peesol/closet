@extends('layouts.app')

@section('content')

<div class="container">
            <div class="large-panel">
            <div class="panel-heading" style="border-bottom: 1px solid #f2f2f2;"><p class="font-bold no-margin">Dropzone</p></div>
            <dropzone></dropzone>
            </div>
</div>
<script>
    window.addEventListener('load', function () {
        var follow = new Vue({
          el: '.large-panel'
        });
    }); 
</script>
@endsection