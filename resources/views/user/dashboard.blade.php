<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
</head>
<body>
    <h1>Welcome, User</h1>

    <h2>Generate Short URL</h2>
    <form method="POST" action="/user/generate">
        @csrf
        <input type="url" name="long_url" required placeholder="Enter long URL">
        <button type="submit">Generate</button>
    </form>

    @if(session('short_url'))
        <p>Short URL: <a href="/{{ session('short_url') }}">{{ session('short_url') }}</a></p>
    @endif

    <h2>Your Short URLs</h2>
    <ul>
        @foreach($urls as $url)
            <li>{{ $url->long_url }} → <a href="/{{ $url->short_url }}">{{ $url->short_url }}</a>
                <a href="/user/delete/{{ $url->id }}">Delete</a></li>
        @endforeach
    </ul>
</body>
</html>
