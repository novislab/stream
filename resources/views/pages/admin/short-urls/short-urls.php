<?php

declare(strict_types=1);

use App\Models\ShortUrl;
use Flux\Flux;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

new #[Layout('layouts::admin')] #[Title('Short URLs')] class extends Component
{
    #[Validate('required|url|max:2048')]
    public string $originalUrl = '';

    #[Validate('nullable|string|max:255')]
    public ?string $title = null;

    #[Validate('nullable|date|after:now')]
    public ?string $expiresAt = null;

    #[Validate('nullable|integer|min:1')]
    public ?int $maxViews = null;

    public ?int $editingId = null;

    public ?int $viewingStatsId = null;

    /**
     * @return Collection<int, ShortUrl>
     */
    #[Computed]
    public function shortUrls(): Collection
    {
        return ShortUrl::query()
            ->withCount('visits')
            ->latest()
            ->get();
    }

    public function createShortUrl(): void
    {
        $this->validate();

        ShortUrl::create([
            'original_url' => $this->originalUrl,
            'title' => $this->title,
            'expires_at' => $this->expiresAt,
            'max_views' => $this->maxViews,
        ]);

        $this->reset(['originalUrl', 'title', 'expiresAt', 'maxViews']);
        unset($this->shortUrls);

        Flux::toast('Short URL created successfully.');
    }

    public function editShortUrl(int $id): void
    {
        $shortUrl = ShortUrl::findOrFail($id);

        $this->editingId = $id;
        $this->originalUrl = $shortUrl->original_url;
        $this->title = $shortUrl->title;
        $this->expiresAt = $shortUrl->expires_at?->format('Y-m-d\TH:i');
        $this->maxViews = $shortUrl->max_views;

        Flux::modal('edit-modal')->show();
    }

    public function updateShortUrl(): void
    {
        $this->validate();

        $shortUrl = ShortUrl::findOrFail($this->editingId);
        $shortUrl->update([
            'original_url' => $this->originalUrl,
            'title' => $this->title,
            'expires_at' => $this->expiresAt,
            'max_views' => $this->maxViews,
        ]);

        $this->cancelEdit();
        unset($this->shortUrls);

        Flux::toast('Short URL updated successfully.');
    }

    public function cancelEdit(): void
    {
        $this->editingId = null;
        $this->reset(['originalUrl', 'title', 'expiresAt', 'maxViews']);
        $this->resetValidation();

        Flux::modal('edit-modal')->close();
    }

    public function toggleActive(int $id): void
    {
        $shortUrl = ShortUrl::findOrFail($id);
        $shortUrl->update(['is_active' => ! $shortUrl->is_active]);
        unset($this->shortUrls);

        Flux::toast($shortUrl->is_active ? 'Short URL activated.' : 'Short URL deactivated.');
    }

    public function deleteShortUrl(int $id): void
    {
        ShortUrl::findOrFail($id)->delete();
        unset($this->shortUrls);

        Flux::toast('Short URL deleted.');
    }

    public function viewStats(int $id): void
    {
        $this->viewingStatsId = $id;
        Flux::modal('stats-modal')->show();
    }

    public function closeStats(): void
    {
        $this->viewingStatsId = null;
        Flux::modal('stats-modal')->close();
    }

    #[Computed]
    public function viewingShortUrl(): ?ShortUrl
    {
        if (! $this->viewingStatsId) {
            return null;
        }

        return ShortUrl::with(['visits' => fn ($query) => $query->latest()->limit(50)])
            ->withCount('visits')
            ->find($this->viewingStatsId);
    }

    public function copyToClipboard(string $url): void
    {
        $this->dispatch('copy-to-clipboard', url: $url);
        Flux::toast('Copied to clipboard!');
    }
};
