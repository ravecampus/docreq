<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" value="{{ csrf_token() }}"/>
    <title>{{env('MIX_APP_NAME')}}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset(url('/css/font-awesome/css/font-awesome.min.css')) }}">
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet"/>
</head>
<body>

<div id="app">
   
</div>
@if (Auth::check())
    @php
    $user_auth_data = [
        'isLoggedin' => true,
        'user' =>  Auth::user()
    ];
    @endphp
@else
    @php
    $user_auth_data = [
        'isLoggedin' => false
    ];
    @endphp
@endif

<script>
    window.Laravel = JSON.parse(atob('{{ base64_encode(json_encode($user_auth_data)) }}'));
</script>


<script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
</body>
</html>