@component('mail::message')

# ** Sub : {{ $subject }} **
##  Hello, {{ $firstName." ".$lastName  }}
{{ $message }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
