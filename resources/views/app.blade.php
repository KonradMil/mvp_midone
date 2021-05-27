<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" value="{{ csrf_token() }}"/>
    <title>{{env('APP_NAME')}}</title>
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet"/>
    <link rel='shortcut icon' type='image/x-icon' href="/s3/favicon.ico">
</head>
<body>
@if (Auth::check())
    <script>
        window.unity_path = '{{env('UNITY_PATH')}}';
        window.Laravel = {!!json_encode([
               'isLoggedin' => true,
               'user' => Auth::user(),
               'teams' => Auth::user()->teams,
               'notifications' => Auth::user()->notifications,
               'company' => Auth::user()->companies,
           ])!!}
    </script>
@else
    <script>
        window.Laravel = {!!json_encode([
                'isLoggedin' => false
            ])!!}
    </script>
@endif
<div id="app">
</div>
<script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
</body>
</html>
