<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ShortUrlFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ShortUrl extends Model
{
    /** @use HasFactory<ShortUrlFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
        'original_url',
        'title',
        'is_active',
        'expires_at',
        'max_views',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'expires_at' => 'datetime',
            'click_count' => 'integer',
            'max_views' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (ShortUrl $shortUrl): void {
            if (empty($shortUrl->code)) {
                $shortUrl->code = self::generateUniqueCode();
            }
        });
    }

    public static function generateUniqueCode(int $length = 6): string
    {
        do {
            $code = Str::random($length);
        } while (self::where('code', $code)->exists());

        return $code;
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<UrlVisit, $this>
     */
    public function visits(): HasMany
    {
        return $this->hasMany(UrlVisit::class);
    }

    /**
     * @param  Builder<ShortUrl>  $query
     * @return Builder<ShortUrl>
     */
    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->where(function (Builder $query): void {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    public function hasReachedMaxViews(): bool
    {
        return $this->max_views !== null && $this->click_count >= $this->max_views;
    }

    public function isAccessible(): bool
    {
        return $this->is_active && ! $this->isExpired() && ! $this->hasReachedMaxViews();
    }

    public function incrementClickCount(): void
    {
        $this->increment('click_count');
    }

    public function getShortUrlAttribute(): string
    {
        return url('s/'.$this->code);
    }
}
