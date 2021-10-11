@extends('emails.layout')
@section('content')
    <h1>{{ __('emails.team_invitation.title') }}</h1>
    <h2>"{{ $teamName }}"</h2>
    <p>
        {{ __('emails.team_invitation.paragraph1', ['teamName' => $teamName])  }}
    </p>
    <a href="{{ url()->route('teams_claim_invitation', ['token' => $confirmationToken]) }}" class="btn">
        {{ __('emails.team_invitation.action1_text') }}
    </a>
    <p>
        {{ __('emails.main.action_alt', ['actionText' => __('emails.team_invitation.action1_text') ]) }}<br/>
        <a href="{{ route('teams_claim_invitation', ['token' => $confirmationToken]) }}">
            {{ route('teams_claim_invitation', ['token' => $confirmationToken]) }}
        </a>
    </p>
@endsection
