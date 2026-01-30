<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\UrlVisitFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class UrlVisit extends Model
{
    /** @use HasFactory<UrlVisitFactory> */
    use HasFactory;

    protected $fillable = [
        'short_url_id',
        'ip_address',
        'user_agent',
        'referer',
        'country',
        'city',
        'device',
        'browser',
        'platform',
    ];

    /**
     * @return BelongsTo<ShortUrl, $this>
     */
    public function shortUrl(): BelongsTo
    {
        return $this->belongsTo(ShortUrl::class);
    }

    public static function recordVisit(ShortUrl $shortUrl, Request $request): self
    {
        $userAgent = $request->userAgent() ?? '';

        return self::create([
            'short_url_id' => $shortUrl->id,
            'ip_address' => $request->ip(),
            'user_agent' => $userAgent,
            'referer' => $request->header('referer'),
            'device' => self::parseDevice($userAgent),
            'browser' => self::parseBrowser($userAgent),
            'platform' => self::parsePlatform($userAgent),
        ]);
    }

    private static function parseDevice(string $userAgent): string
    {
        if (preg_match('/Mobile|Android|iPhone|iPad/i', $userAgent)) {
            if (preg_match('/iPad/i', $userAgent)) {
                return 'Tablet';
            }

            return 'Mobile';
        }

        return 'Desktop';
    }

    private static function parseBrowser(string $userAgent): string
    {
        $browsers = [
            'Edge' => '/Edg/i',
            'Chrome' => '/Chrome/i',
            'Firefox' => '/Firefox/i',
            'Safari' => '/Safari/i',
            'Opera' => '/Opera|OPR/i',
            'IE' => '/MSIE|Trident/i',
        ];

        foreach ($browsers as $browser => $pattern) {
            if (preg_match($pattern, $userAgent)) {
                return $browser;
            }
        }

        return 'Unknown';
    }

    private static function parsePlatform(string $userAgent): string
    {
        $platforms = [
            'Windows' => '/Windows/i',
            'macOS' => '/Macintosh/i',
            'Linux' => '/Linux/i',
            'iOS' => '/iPhone|iPad/i',
            'Android' => '/Android/i',
        ];

        foreach ($platforms as $platform => $pattern) {
            if (preg_match($pattern, $userAgent)) {
                return $platform;
            }
        }

        return 'Unknown';
    }
}
