<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Reset your CE Zoom Password</h2>

<p>Per your request here is the link to reset your password:</p>

<p><a href="{!! route('auth.reset', $token) !!}">{!! route('auth.reset', $token) !!}</a></p>

<p>If you did not issue this request please contact us immediately.</p>

<p>
    Regards,<br/>
    {{ $site_name }}
</p>

</body>
</html>