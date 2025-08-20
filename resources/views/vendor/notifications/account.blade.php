<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Sky Hybrid Portal</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 40px auto; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 20px;">
        <h1 style="color: #1a202c; font-size: 24px; margin-bottom: 20px;">Hello {{ $user->name }},</h1>
        <br/>
        <p style="color: #4a5568; line-height: 1.5; margin: 10px 0;">
            Your account has been created successfully.
        </p>
        <p style="color: #4a5568; line-height: 1.5; margin: 10px 0;">
            Username : {{ $user->email }}
        </p>
        <p style="color: #4a5568; line-height: 1.5; margin: 10px 0;">
           Password : {{ $passwordText }}
        </p>
        <br/>
        <br/>
        <p style="color: #4a5568; line-height: 1.5; margin: 10px 0;">
            Please visit the Sky Hybrid Portal by clicking the link below.
        </p>

        <div style="text-align: center; margin: 20px 0;">
            <a href="{{ $portalUrl }}" style="background-color: #3490dc; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">
                Visit the Portal
            </a>
        </div>

        <p style="color: #4a5568; line-height: 1.5; margin: 10px 0;">
            Thank you for using our application!
        </p>

        <p style="color: #a0aec0; font-size: 12px; text-align: center; margin-top: 30px;">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </p>
    </div>
</body>
</html>
