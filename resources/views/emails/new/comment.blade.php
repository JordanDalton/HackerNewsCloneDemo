<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>There's a new comment @ {{ $site_name }}!</h2>

<p>Check it out: <a href="{{ route('comments.show', $id) }}"></a>{{ route('comments.show', $id) }}</p>

<blockquote>
    {{ strip_tags( nl2br( $comment ), '<br>') }}
</blockquote>

<p>
    Regards,<br/>
    {{ $site_name }}
</p>

</body>
</html>