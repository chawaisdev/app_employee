<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Account Created</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background-color: #1e293b;
            padding: 20px;
            text-align: center;
        }

        .email-header img {
            max-height: 60px;
        }

        .email-body {
            padding: 30px;
            color: #444;
            font-size: 15px;
            line-height: 1.6;
        }

        .email-body h2 {
            color: #1e293b;
            margin-bottom: 15px;
        }

        .email-body p {
            margin: 10px 0;
        }

        .login-btn {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 25px;
            background-color: #2563eb;
            color: #ffffff !important;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            border-radius: 6px;
        }

        .login-btn:hover {
            background-color: #1e40af;
        }

        .email-footer {
            margin-top: 30px;
            font-size: 13px;
            text-align: center;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- HEADER -->
        <div class="email-header">
            <img src="{{ $message->embed(public_path('assets/images/Asset 6.png')) }}" alt="Logo"
                style="max-height:60px;">

        </div>

        <!-- BODY -->
        <div class="email-body">
            <h2>Hello {{ $name }},</h2>
            <p>Your account has been created successfully. Here are your login details:</p>

            <p><strong>Email:</strong> {{ $email }}</p>
            <p><strong>Password:</strong> {{ $plainPassword }}</p>

            <p>You can now log in to your account using the button below:</p>

            <a href="http://127.0.0.1:8000/" class="login-btn">Login to Your Account</a>

            <div class="email-footer">
                <p>Thanks,<br>{{ config('app.name') }}</p>
            </div>
        </div>
    </div>
</body>

</html>
