@component('mail::message')

# From : {{ $report['email'] }}
## {{ $report['name'] }}

@component('mail::panel')

{{ $report['body'] }}

@endcomponent


@endcomponent
