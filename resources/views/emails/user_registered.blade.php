<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Account Created</title>
</head>
<body>
    <h2>Hello {{ $name }},</h2>
    <p>Your account has been created successfully. Here are your login details:</p>

    <p><strong>Email:</strong> {{ $email }}</p>
    <p><strong>Password:</strong> {{ $plainPassword }}</p>

    <p>You can now log in to your account.</p>
    <br>
    <p>Thanks,</p>
    <p>{{ config('app.name') }}</p>
</body>
</html>
