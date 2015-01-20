<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
    <h2>Thank you for joining {{ $site_name }}!</h2>
    <p>
        In order to activate your account please visit the following link:
    </p>
    <p>
        <a href="{!! route('auth.email.verify', $email_authentication_code) !!}">{!! route('auth.email.verify', $email_authentication_code) !!}</a>
    </p>

    <p>
        Regards,<br/>
        {{ $site_name }}
    </p>

</body>
</html>