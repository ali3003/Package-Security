<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email</title>
</head>
<body>
    <h1 style="text-align: center; color: #4CAF50;">Verify Your Email</h1>
    <p>Dear {{$name}},</p>
    <p>Thank you for <strong>registering</strong>. Please use the <b>code</b> below to verify your email address:</p>
    <h2 style="text-align: center; color: #df1313;">{{ $code }}</h2>
    <p>If you didn't request this, please ignore this email.</p>
    <p>Best regards,<br><br>{{ config('app.name') }} Team</p>
</body>
</html>
