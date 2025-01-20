<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Digital NameCard</title>
    <link rel="icon" type="image/x-icon" href="{{ url('img/vbeicon.ico') }}">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

</head>
<style>

</style>

<body>
    @include('sweetalert::alert')


    <div id="appvue"></div>


    <script src="{{ mix('js/app.js') }}" defer></script>
</body>

</html>
