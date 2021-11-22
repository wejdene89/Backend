<style>

    p{
       
        font-weight: bold;
    }
</style>


<p>Click on the button below to change password</p>

@component('mail::button', ['url' => 'http://localhost:4200/response-reset?token='.$token])
Reset Password
@endcomponent

<p>Thanks</p>,<br>
