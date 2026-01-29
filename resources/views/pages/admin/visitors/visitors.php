<?php

declare(strict_types=1);

use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;
use Shetabit\Visitor\Models\Visit;

new #[Layout('layouts::admin')] #[Title('Visitors')] #[Lazy]
class extends Component
{
    public int $perPage = 20;

    public array $visitors = [];

    public bool $hasMore = true;

    public function mount(): void
    {
        $this->loadVisitors();
    }

    public function loadMore(): void
    {
        $this->loadVisitors();
    }

    public function placeholder(): string
    {
        return <<<'HTML'
        <div class="space-y-6">
            <div class="flex items-center gap-2">
                <div class="h-4 w-4 bg-zinc-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                <div class="h-4 w-20 bg-zinc-200 dark:bg-zinc-700 rounded animate-pulse"></div>
            </div>
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="h-8 w-32 bg-zinc-200 dark:bg-zinc-700 rounded animate-pulse mb-2"></div>
                    <div class="h-4 w-64 bg-zinc-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                </div>
            </div>
            <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 dark:bg-zinc-950 overflow-hidden">
                <div class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 px-4 py-3">
                    <div class="flex gap-4">
                        <div class="h-4 w-20 bg-zinc-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        <div class="h-4 w-24 bg-zinc-200 dark:bg-zinc-700 rounded animate-pulse hidden sm:block"></div>
                        <div class="h-4 w-16 bg-zinc-200 dark:bg-zinc-700 rounded animate-pulse hidden md:block"></div>
                        <div class="h-4 w-20 bg-zinc-200 dark:bg-zinc-700 rounded animate-pulse hidden lg:block"></div>
                        <div class="h-4 w-16 bg-zinc-200 dark:bg-zinc-700 rounded animate-pulse ml-auto"></div>
                    </div>
                </div>
                <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @for($i = 0; $i < 10; $i++)
                        <div class="px-4 py-3 flex items-center gap-4">
                            <div class="flex items-center gap-2 flex-1">
                                <div class="h-4 w-4 bg-zinc-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                                <div class="h-4 w-32 bg-zinc-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                            </div>
                            <div class="h-4 w-24 bg-zinc-200 dark:bg-zinc-700 rounded animate-pulse hidden sm:block"></div>
                            <div class="h-4 w-16 bg-zinc-200 dark:bg-zinc-700 rounded animate-pulse hidden md:block"></div>
                            <div class="h-4 w-20 bg-zinc-200 dark:bg-zinc-700 rounded animate-pulse hidden lg:block"></div>
                            <div class="h-4 w-20 bg-zinc-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
        HTML;
    }

    protected function loadVisitors(): void
    {
        $newVisitors = Visit::query()
            ->latest()
            ->skip(count($this->visitors))
            ->take($this->perPage)
            ->get()
            ->map(fn (Visit $visit) => [
                'id' => $visit->id,
                'url' => $this->truncateUrl($visit->url),
                'full_url' => $visit->url,
                'ip' => $visit->ip,
                'device' => ucfirst($visit->device ?? 'Unknown'),
                'platform' => ucfirst($visit->platform ?? 'Unknown'),
                'browser' => ucfirst($visit->browser ?? 'Unknown'),
                'referer' => $visit->referer ? parse_url($visit->referer, PHP_URL_HOST) : '-',
                'created_at' => $visit->created_at->diffForHumans(),
                'created_at_full' => $visit->created_at->format('M d, Y H:i'),
            ])
            ->toArray();

        $this->visitors = array_merge($this->visitors, $newVisitors);
        $this->hasMore = count($newVisitors) === $this->perPage;
    }

    protected function truncateUrl(?string $url): string
    {
        if (! $url) {
            return '/';
        }

        $path = parse_url($url, PHP_URL_PATH) ?? '/';

        return strlen($path) > 40 ? substr($path, 0, 40).'...' : $path;
    }
};
