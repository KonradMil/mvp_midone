@extends('emails.layout')
@section('content')
    <h1>{{ __('emails.restore_password.title') }}</h1>
    <h2>{{ __('emails.restore_password.subtitle') }}</h2>
    <p>
        {{ __('emails.restore_password.paragraph1')  }}
    </p>
    <a href="{{ url()->route('reset_password', ['token' => $token]) }}" class="btn">
        {{ __('emails.restore_password.action1_text') }}
    </a>
    <p>
        {{ __('emails.main.action_alt', ['actionText' => __('emails.restore_password.action1_text') ]) }}<br/>
        <a href="{{ route('reset_password', ['token' => $token]) }}">
            {{ route('reset_password', ['token' => $token]) }}
        </a>
    </p>
@endsection
