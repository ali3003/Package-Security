<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
            max-width: 600px;
        }
        .email-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .email-header h1 {
            color: #4CAF50;
        }
        .email-body {
            font-size: 16px;
            color: #555;
        }
        .email-footer {
            text-align: center;
            font-size: 14px;
            color: #aaa;
            margin-top: 30px;
        }
        .btn {
            display: inline-block;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Hello, {{ $name }}!</h1>
        </div>
        <div class="email-body">
            <p>You are on your way to resetting your password. <br>
            If you requested a password reset, please click the link below:</p>
            
            <a href="{{ $url }}" class="btn">Reset Password</a>
            
            <p>If you did not request a password reset, you can ignore this email.</p>
            
            <p>Best regards, <br> The Support Team.</p>
        </div>
        <div class="email-footer">
        Psec
        </div>
    </div>
</body>
</html>
