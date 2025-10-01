<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f4f6f9; padding:20px;">
    <div style="max-width:600px; margin:auto; background:#fff; border-radius:8px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
        <div style="background:#1e293b; padding:20px; text-align:center;">
            <img src="{{ $message->embed(public_path('assets/images/Asset 6.png')) }}" alt="Logo"
                style="max-height:60px;">
        </div>
        <div style="padding:30px; color:#333;">
            <h2>Hello {{ $employee->full_name }},</h2>
            <p>Welcome aboard! Your account has been created successfully. Here are your login details:</p>

            <p><strong>Email:</strong> {{ $employee->email }}</p>
            <p><strong>Password:</strong> {{ $plainPassword }}</p>

            <p>You can now log in using the button below:</p>

            <a href="{{ url('/employee/login') }}" style="display:inline-block; padding:12px 24px; background:#2563eb; color:#fff; font-weight:bold; text-decoration:none; border-radius:6px;">Login to Your Account</a>

            <p style="margin-top:30px; color:#777;">Thanks,<br>{{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>
