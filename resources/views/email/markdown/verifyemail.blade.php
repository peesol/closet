@component('mail::message')
# {{__('message.verification_welcome', ['name' => $name])}}.

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
