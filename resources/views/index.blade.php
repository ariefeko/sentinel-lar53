@extends('layouts.master')

@section('content')
    <h1>Upload Image</h1>

    <form action="/image" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <p>
            <label for="image">Image:</label>
            <input type="file" name="image" id="image"><br>
        </p>
        <p>
            <input type="submit" name="submit" value="Upload Image">
        </p>
    </form>

    @if (session('thumb'))
        <p>Saved thumbnail:</p>
        <img src="/uploads/crops/{!! session('thumb') !!}" alt="saved before">
    @endif
@stop