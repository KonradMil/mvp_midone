@extends('emails.layout')
@section('content')

    <h1>NOWE ZGŁOSZENIE</h1>
    <h2>{{ $user->name }} {{ $user->lastname }} {{ $user->email }}</h2>
    <p>
        Do tej pory zapisało się {{ count($users) }} użytkowników
    </p>

    <p>
        <br>
        Obecna lista uczestników:
    </p>

    <p>
    <p>
        @foreach($users as $k => $u)
            {{ ($k+1) }}. {{ $u->name }} {{ $u->lastname }} {{ $u->email }} tel. {{ $u->phone_number }} <br>
        @endforeach
    </p>
    </p>

@endsection
