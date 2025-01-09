<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function generateShortUrl(Request $request)
    {
        $request->validate([
            'long_url' => 'required|url|unique:short_urls,long_url',
        ]);

        $shortUrl = Str::random(6);  // Random short string

        ShortUrl::create([
            'long_url' => $request->long_url,
            'short_url' => $shortUrl,
            'user_id' => auth()->id(),
        ]);

        return back()->with('short_url', $shortUrl);
    }

    public function listUrls()
    {
        $urls = ShortUrl::where('user_id', auth()->id())->paginate(10);
        return view('user.dashboard', compact('urls'));
    }
}
