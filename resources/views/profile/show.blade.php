@extends('layouts.app')

@section('content')
    <h2>Two-Factor Authentication</h2>

    @if (session('status') === 'two-factor-authentication-enabled')
        <p>Please scan the QR code and confirm your setup.</p>
        {!! auth()->user()->twoFactorQrCodeSvg() !!}
        <form method="POST" action="/user/two-factor-authentication">
            @csrf
            @method('PUT')
            <input type="text" name="code" placeholder="Enter 2FA Code" required>
            <button type="submit">Confirm</button>
        </form>
    @else
        <form method="POST" action="/user/two-factor-authentication">
            @csrf
            <button type="submit">Enable 2FA</button>
        </form>
    @endif
@endsection
