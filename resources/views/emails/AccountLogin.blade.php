<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        p {
            color: #555;
        }
        .footer {
            margin-top: 20px;
            color: #777;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Hello, {{ $name }}</h1>
        <p>We are excited to inform you about the upcoming event:</p>
        <p><strong>Location:</strong> {{ $location }}</p>
        <p><strong>Date & Time:</strong> {{ $time }}</p>

        <p>We look forward to seeing you there!</p>

        <p>Best Regards,<br>Event Team</p>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Psec. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
