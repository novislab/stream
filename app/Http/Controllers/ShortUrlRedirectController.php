<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use App\Models\UrlVisit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ShortUrlRedirectController extends Controller
{
    public function __invoke(Request $request, string $code): RedirectResponse
    {
        $shortUrl = ShortUrl::where('code', $code)->firstOrFail();

        if (! $shortUrl->isAccessible()) {
            abort(404);
        }

        $shortUrl->incrementClickCount();
        UrlVisit::recordVisit($shortUrl, $request);

        return redirect()->away($shortUrl->original_url);
    }
}
