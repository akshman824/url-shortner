<?php

// app/Http/Controllers/ShortUrlController.php
namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{
    public function generateShortUrl(Request $request)
    {
        // Validate the incoming long URL
        $validated = $request->validate([
            'long_url' => 'required|url',
        ]);

        // Check if the URL already exists in the database for the current team
        $existingUrl = ShortUrl::where('long_url', $validated['long_url'])
            ->where('team_id', auth()->user()->team_id)
            ->first();

        // If URL already exists, return the existing short URL
        if ($existingUrl) {
            return response()->json([
                'message' => 'URL already shortened',
                'short_url' => $existingUrl->short_url,
            ]);
        }

        // Generate a new unique short URL
        $shortUrl = $this->generateUniqueShortUrl();

        // Store the long URL and short URL in the database
        ShortUrl::create([
            'team_id' => auth()->user()->team_id,
            'long_url' => $validated['long_url'],
            'short_url' => $shortUrl,
        ]);

        return response()->json([
            'short_url' => $shortUrl,
        ]);
    }

    // Helper function to generate a unique short URL
    private function generateUniqueShortUrl()
    {
        $shortUrl = Str::random(6);  // Generate a random string of 6 characters

        // Check if the generated short URL already exists, if so, regenerate
        while (ShortUrl::where('short_url', $shortUrl)->exists()) {
            $shortUrl = Str::random(6);
        }

        return $shortUrl;
    }
    public function viewShortUrls()
{
    // Fetch all short URLs for the authenticated user's team
    $shortUrls = ShortUrl::where('team_id', auth()->user()->team_id)->paginate(10);

    return view('shortUrls.index', compact('shortUrls'));
}
public function delete($id)
{
    $shortUrl = ShortUrl::find($id);
    $shortUrl->delete();

    return back()->with('message', 'Short URL deleted successfully!');
}
}

