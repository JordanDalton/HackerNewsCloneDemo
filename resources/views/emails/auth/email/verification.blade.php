<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
    <h2>Thank you for joining {{ $site_name }}!</h2>
    <div>
        In order to activate your account please visit the following link:
    </div>
    <div>
        <a href="{!! route('auth.email.verify', $email_authentication_code) !!}">{!! route('auth.email.verify', $email_authentication_code) !!}</a>
    </div>
</body>
</html>