<?php

// app/Http/Controllers/Api/ShortUrlApiController.php
namespace App\Http\Controllers\Api;

use App\Models\ShortUrl;
use App\Models\AccessToken;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortUrlApiController extends Controller
{
    public function generateShortUrl(Request $request)
    {
        $validated = $request->validate([
            'long_url' => 'required|url',
            'token' => 'required|exists:access_tokens,token',
        ]);

        // Validate the access token
        $accessToken = AccessToken::where('token', $validated['token'])->first();

        if ($accessToken->expires_at < now()) {
            return response()->json(['error' => 'Token expired'], 401);
        }

        // Generate and return short URL logic
        $shortUrl = $this->generateUniqueShortUrl();

        // Store the new URL
        ShortUrl::create([
            'team_id' => $accessToken->team_id,
            'long_url' => $validated['long_url'],
            'short_url' => $shortUrl,
        ]);

        return response()->json([
            'short_url' => $shortUrl,
        ]);
    }

    public function deleteShortUrl(Request $request)
    {
        $validated = $request->validate([
            'short_url' => 'required',
            'token' => 'required|exists:access_tokens,token',
        ]);

        // Validate the access token
        $accessToken = AccessToken::where('token', $validated['token'])->first();

        if ($accessToken->expires_at < now()) {
            return response()->json(['error' => 'Token expired'], 401);
        }

        // Delete the short URL
        ShortUrl::where('short_url', $validated['short_url'])
            ->where('team_id', $accessToken->team_id)
            ->delete();

        return response()->json([
            'message' => 'Short URL deleted successfully',
        ]);
    }
}
