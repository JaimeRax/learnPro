@component('mail::message')
Hello {{ $user->name }},
<p>We</p>

@component('mail::button', ['url' => url('/reset/' . $user->remember_token)])
Reset Your Password
@endcomponent


<p>In cas</p>
Thanks, <br>
{{ config('app.name') }}
@endcomponent
