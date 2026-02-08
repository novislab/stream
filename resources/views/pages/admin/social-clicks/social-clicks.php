<?php

declare(strict_types=1);

use App\Models\SocialLink;
use App\Models\SocialLinkClick;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts::admin')] #[Title('Admin Social Clicks')] class extends Component
{
    public bool $hasMore = true;

    public int $perPage = 20;

    public function loadMore(): void
    {
        $this->perPage += 20;
        $this->hasMore = SocialLinkClick::query()->count() > $this->perPage;
    }

    #[Computed]
    public function socialClicks(): array
    {
        return SocialLinkClick::query()
            ->with('socialLink')
            ->orderByDesc('created_at')
            ->limit($this->perPage)
            ->get()
            ->map(fn (SocialLinkClick $click) => [
                'id' => $click->id,
                'platform' => $click->socialLink->platform ?? 'Unknown',
                'url' => $click->socialLink->url ?? '#',
                'ip_address' => $click->ip_address ?? 'N/A',
                'user_agent' => $click->user_agent ?? 'N/A',
                'referer' => $click->referer ?? 'Direct',
                'created_at' => $click->created_at->format('M d, Y'),
                'created_at_full' => $click->created_at->toISOString(),
            ])
            ->toArray();
    }

    #[Computed]
    public function totalClicks(): int
    {
        return SocialLinkClick::query()->count();
    }

    #[Computed]
    public function clicksByPlatform(): array
    {
        return SocialLink::query()
            ->withCount('clicks')
            ->get()
            ->map(fn (SocialLink $link) => [
                'platform' => $link->platform,
                'url' => $link->url,
                'click_count' => $link->clicks_count,
            ])
            ->sortByDesc('click_count')
            ->toArray();
    }

    #[Computed]
    public function socialLinks(): array
    {
        return SocialLink::query()
            ->withCount('clicks')
            ->get()
            ->map(fn (SocialLink $link) => [
                'id' => $link->id,
                'platform' => $link->platform,
                'url' => $link->url,
                'click_count' => $link->clicks_count,
            ])
            ->toArray();
    }
};
