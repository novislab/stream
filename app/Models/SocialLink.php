<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\SocialLinkFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SocialLink extends Model
{
    /** @use HasFactory<SocialLinkFactory> */
    use HasFactory;

    protected $fillable = [
        'platform',
        'url',
    ];

    public function clicks(): HasMany
    {
        return $this->hasMany(SocialLinkClick::class);
    }

    public function clickCount(): int
    {
        return $this->clicks()->count();
    }
}
