<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $actionName }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f8;
            margin: 0;
            padding: 0;
        }
        .email-container {
            background-color: #ffffff;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            color: #333;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
        }
        .content {
            margin: 20px 0;
            text-align: center;
        }
        .content p {
            font-size: 18px;
            color: #555;
            line-height: 1.6;
        }
        .cta-button {
            display: inline-block;
            padding: 12px 24px;
            margin: 20px 0;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>{{ $actionName }}</h1>
        </div>
        <div class="content">
            <p>Hello <strong>{{ $name }}</strong>,</p>
            <p>{{ $action }}</p>
            <a href="#" class="cta-button">Take Action</a>
        </div>
        <div class="footer">
            <p>Thank you for being part of our service!</p>
            <p>&copy; {{ date('Y') }} Psec. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
