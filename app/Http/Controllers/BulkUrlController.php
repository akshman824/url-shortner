<?php

// app/Http/Controllers/BulkUrlController.php
namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UrlsImport;

class BulkUrlController extends Controller
{
    public function showBulkForm()
    {
        return view('bulkUrl.form');
    }

    public function processBulkUpload(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        // Handle the bulk URL upload using a job or direct processing
        $path = $request->file('file')->store('temp');

        // Handle CSV import
        $import = new UrlsImport(auth()->user()->team_id);
        Excel::import($import, $path);

        return redirect()->route('bulkUrl.download');
    }

    public function downloadCsv()
    {
        $shortUrls = ShortUrl::where('team_id', auth()->user()->team_id)->get();

        $csvContent = "Long URL,Short URL\n";
        foreach ($shortUrls as $shortUrl) {
            $csvContent .= "{$shortUrl->long_url},{$shortUrl->short_url}\n";
        }

        return response($csvContent, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="short_urls.csv"');
    }
}
