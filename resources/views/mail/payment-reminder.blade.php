@component('mail::message')

# ** Sub : Reminder About Your Plane expire **
##  Hello, {{ $member->first_name." ".$member->last_name  }}

Your plane expire date {{ $member->validity_date}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
