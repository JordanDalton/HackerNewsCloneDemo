<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>There's a new post @ {{ $site_name }}!</h2>

<p>Check it out: <a href="{{ route('posts.show', $id) }}">{{ $title }}</a></p>

<p>
    Regards,<br/>
    {{ $site_name }}
</p>

</body>
</html>