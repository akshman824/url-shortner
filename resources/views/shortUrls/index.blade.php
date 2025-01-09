{{-- resources/views/shortUrls/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Your Shortened URLs</h1>
    <table>
        <thead>
            <tr>
                <th>Long URL</th>
                <th>Short URL</th>
                <th>Hit Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($shortUrls as $shortUrl)
                <tr>
                    <td>{{ $shortUrl->long_url }}</td>
                    <td><a href="{{ url($shortUrl->short_url) }}" target="_blank">{{ $shortUrl->short_url }}</a></td>
                    <td>{{ $shortUrl->hit_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $shortUrls->links() }}
@endsection
