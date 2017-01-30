@extends('layouts.master')

@section('header_styles')
    <link rel="stylesheet" type="text/css" href="/css/jquery.Jcrop.min.css">

    <style type="text/css">
        #preview
        {
            width: 120px;
            height: 100px;
            overflow:hidden;
        }
    </style>
@stop

@section('content')
    @php $folder = 'uploads/images/'; @endphp
    <h1>Crop Image: Laravel + JCrop</h1>
    <table>
        <tr>
            <td>
                <img src="{{ $folder.$filename }}" id="cropbox" alt="cropbox">
            </td>
            <td>
                Thumb Preview:
                <div id="preview">
                    <img src="{{ $folder.$filename }}" alt="thumb">
                </div>
            </td>
        </tr>
    </table>

    <form action="/crop" method="post">
        {{ csrf_field() }}
        <input type="hidden" id="x" name="x">
        <input type="hidden" id="y" name="y">
        <input type="hidden" id="w" name="w">
        <input type="hidden" id="h" name="h">
        <input type="hidden" name="filename" value="{{ $filename }}">
        <input type="submit" value="Crop Images">
    </form>
@stop

@section('footer_styles')
    {{-- <script type="text/javascript" src="/js/jquery.min.js"></script> --}}
    <script type="text/javascript" src="/js/jquery.color.js"></script>
    <script type="text/javascript" src="/js/jquery.Jcrop.min.js"></script>

    <script type="text/javascript">
        $(function () {
            $('#cropbox').Jcrop({
                aspectRatio: 120 / 100,
                setSelect: [0,0,500,{{ $height }}],
                onSelect: updateCoords,
                onChange: updateCoords,
            });

            function updateCoords(c)
            {
                showPreview(c);
                $('#x').val(c.x);
                $('#y').val(c.y);
                $('#w').val(c.w);
                $('#h').val(c.h);
            }

            function showPreview(coords)
            {
                var rx = 120 / coords.w;
                var ry = 100 / coords.h;
                console.log(coords);

                $("#preview img").css({
                    width: Math.round(rx * 500) + 'px',
                    height: Math.round(ry * {{ $height }}) + 'px',
                    marginLeft: '-' + Math.round(rx * coords.x) + 'px',
                    marginTop: '-' + Math.round(ry * coords.y) + 'px',
                });
            }
        });
    </script>
@stop