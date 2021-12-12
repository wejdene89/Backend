@component('mail::message')


Acceptation

@component('mail::button', ['url' => 'http://localhost:4200/login'])
Login 
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
