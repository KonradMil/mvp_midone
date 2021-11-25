<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" value="{{ csrf_token() }}"/>
    <title>{{env('APP_NAME')}}</title>
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet"/>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#a80085">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#a9a9a9">
</head>
<body>

<script>
    window.unity_path = '{{env('UNITY_PATH')}}';
    window.unity_workshop_path = '{{env('UNITY_WORKSHOP_PATH')}}';
    window.unity_tutorial_path = '{{env('UNITY_PATH')}}';
    window.unity_hangar_path = '{{env('UNITY_HANGAR_PATH')}}';
    window.app_path = '{{env('APP_URL')}}';
    window.error = @php echo Session::get('error') ? '"'.Session::get('error').'"' : 'null' @endphp;
    window.warning = @php echo Session::get('warning') ? '"'.Session::get('warning').'"' : 'null' @endphp;
    window.info = @php echo Session::get('info') ? '"'.Session::get('info').'"' : 'null' @endphp;
    window.success = @php echo Session::get('success') ? '"'.Session::get('success').'"' : 'null' @endphp;
    window.invitationToken = @php echo Session::get('teamInvitation') ? '"'.Session::get('teamInvitation').'"' : 'null' @endphp;
    window.impersonationToken = @php echo Session::get('impersonationToken')  ? '"' . Session::get('impersonationToken') . '"' : 'null' @endphp;
</script>

@if (Auth::check())
    <script>

        @php
            if(empty(Auth::user()->companies->toArray())) {
                   $company = new App\Models\Company();
                   $company->author_id = Auth::user()->id;
                   $company->save();
                   $company->users()->attach(Auth::user());
            } else {
                $company = Auth::user()->companies->toArray()[0];
            }
            $teams = Auth::user()->teams;
            $teamsAr = [];
            foreach ($teams as $team) {
                $teamsAr[] = $team->id;
            }

        @endphp
            window.Laravel = {!!json_encode([
               'isLoggedin' => true,
               'user' => Auth::user(),
               'teams' => $teams,
               'teamsar' => $teamsAr,
               'notifications' => Auth::user()->notifications,
               'company' => $company,
               'permissions' => \App\Http\Controllers\UserController::userPermissions(Auth::user())

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
