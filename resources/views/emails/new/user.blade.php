<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>You have a new user!</h2>

<p>{{ $username }} has joined the site. To check out their profile <a href="{{ route('users.show', $username) }}">click here</a>.</p>

<p>
    Regards,<br/>
    {{ $site_name }}
</p>

</body>
</html>