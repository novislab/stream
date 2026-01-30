<?php

declare(strict_types=1);

use App\Models\ShortUrl;
use App\Models\UrlVisit;
use Flux\Flux;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts::admin')] #[Title('Short URL Stats')] class extends Component
{
    public ShortUrl $shortUrl;

    public function mount(ShortUrl $shortUrl): void
    {
        $this->shortUrl = $shortUrl;
    }

    /**
     * @return Collection<int, UrlVisit>
     */
    #[Computed]
    public function recentVisits(): Collection
    {
        return $this->shortUrl->visits()
            ->latest()
            ->limit(100)
            ->get();
    }

    /**
     * @return array<string, int>
     */
    #[Computed]
    public function browserStats(): array
    {
        return $this->shortUrl->visits()
            ->selectRaw('browser, COUNT(*) as count')
            ->groupBy('browser')
            ->orderByDesc('count')
            ->pluck('count', 'browser')
            ->toArray();
    }

    /**
     * @return array<string, int>
     */
    #[Computed]
    public function deviceStats(): array
    {
        return $this->shortUrl->visits()
            ->selectRaw('device, COUNT(*) as count')
            ->groupBy('device')
            ->orderByDesc('count')
            ->pluck('count', 'device')
            ->toArray();
    }

    /**
     * @return array<string, int>
     */
    #[Computed]
    public function platformStats(): array
    {
        return $this->shortUrl->visits()
            ->selectRaw('platform, COUNT(*) as count')
            ->groupBy('platform')
            ->orderByDesc('count')
            ->pluck('count', 'platform')
            ->toArray();
    }

    /**
     * @return array<string, int>
     */
    #[Computed]
    public function dailyVisits(): array
    {
        return $this->shortUrl->visits()
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();
    }

    /**
     * @return array<array{label: string, views: int}>
     */
    #[Computed]
    public function chartData(): array
    {
        $data = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $data[] = [
                'label' => now()->subDays($i)->format('M d'),
                'views' => $this->dailyVisits[$date] ?? 0,
            ];
        }

        return $data;
    }

    public function copyToClipboard(): void
    {
        $this->dispatch('copy-to-clipboard', url: $this->shortUrl->short_url);
        Flux::toast('Copied to clipboard!');
    }
};
