<?php

// app/Http/Controllers/RedirectController.php
namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function redirect($shortUrl)
    {
        // Find the short URL in the database
        $url = ShortUrl::where('short_url', $shortUrl)->firstOrFail();

        // Increment the hit count
        $url->increment('hit_count');

        // Redirect to the long URL
        return redirect()->away($url->long_url);
    }
}

