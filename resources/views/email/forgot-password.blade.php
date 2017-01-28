<h1>Hallo,</h1>

<p>
    Klik link berikut untuk mereset password Anda,

    <a href="{{ env('APP_URL') }}/reset/{{ $user->email }}/{{ $code }}">reset password.</a>
</p>