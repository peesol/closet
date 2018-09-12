@component('mail::message')
# {{__('auth.verification_welcome', ['name' => $name])}}.

{{__('auth.verify_link')}}

@component('mail::button', ['url' => url('/register/verify/'.$email_token)])

    Click

@endcomponent

@component('mail::subcopy')

{{__('auth.verify_alt')}}

{{url('/register/verify/'.$email_token)}}

@endcomponent

{{config('app.name')}}

@endcomponent
