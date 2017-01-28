<h1>Hallo,</h1>

<p>
    Klik link berikut untuk mengaktifkan account Anda,

    <a href="{{ env('APP_URL') }}/activate/{{ $user->email }}/{{ $code }}">Aktifkan akun saya.</a>
</p>