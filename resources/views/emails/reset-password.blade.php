@component('mail::message')
# Reset Password

Click the button below to reset your password:

@component('mail::button', ['url' => $resetUrl])
Reset Password
@endcomponent

This link will expire in {{ config('auth.passwords.'.config('auth.defaults.passwords').'.expire') }} minutes.

If you didn’t request a password reset, you can ignore this email.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
