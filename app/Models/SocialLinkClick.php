<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\SocialLinkClickFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialLinkClick extends Model
{
    /** @use HasFactory<SocialLinkClickFactory> */
    use HasFactory;

    protected $fillable = [
        'social_link_id',
        'ip_address',
        'user_agent',
        'referer',
    ];

    public function socialLink(): BelongsTo
    {
        return $this->belongsTo(SocialLink::class);
    }
}
