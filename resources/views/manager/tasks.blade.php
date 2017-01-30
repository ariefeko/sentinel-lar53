@include('layouts.errors')

this is tasks, with role manager

<form action="/logout" method="POST" id="logout-form">
    {{ csrf_field() }}

    <a href="#" onclick="document.getElementById('logout-form').submit()">Logout</a>
</form>