@component('mail::message')
# Welcome to Closet.

Please, click this link to verify your email.

@component('mail::button', ['url' => url('/register/verify/'.$email_token)])

    Verify

@endcomponent

@component('mail::subcopy')

If you’re having trouble clicking the "Verify" button, copy and paste the URL below into your web browser: 

{{url('/register/verify/'.$email_token)}}

@endcomponent

Thank you,<br>
{{config('app.name')}}

@endcomponent

