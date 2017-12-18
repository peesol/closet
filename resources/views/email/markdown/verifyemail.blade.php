@component('mail::message')
# Welcome to Closet.

{{__('message.verify')}}

@component('mail::button', ['url' => url('/register/verify/'.$email_token)])

    Click

@endcomponent

@component('mail::subcopy')

{{__('message.verify_alt')}}

{{url('/register/verify/'.$email_token)}}

@endcomponent

{{config('app.name')}}

@endcomponent
