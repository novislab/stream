<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <flux:button variant="ghost" size="sm" icon="arrow-left" href="{{ route('admin.short-urls') }}" wire:navigate />
                <flux:heading size="xl">{{ $shortUrl->title ?? 'URL Statistics' }}</flux:heading>
            </div>
            <div class="flex items-center gap-3">
                <button
                    type="button"
                    wire:click="copyToClipboard"
                    class="text-sm text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1"
                >
                    <flux:icon name="link" variant="mini" class="size-4" />
                    {{ $shortUrl->short_url }}
                </button>
                @if ($shortUrl->isExpired())
                    <flux:badge color="amber" size="sm">Expired</flux:badge>
                @elseif ($shortUrl->hasReachedMaxViews())
                    <flux:badge color="red" size="sm">Max Views Reached</flux:badge>
                @elseif ($shortUrl->is_active)
                    <flux:badge color="green" size="sm">Active</flux:badge>
                @else
                    <flux:badge color="zinc" size="sm">Inactive</flux:badge>
                @endif
            </div>
        </div>
        <flux:button variant="primary" icon="pencil" href="{{ route('admin.short-urls') }}" wire:navigate>
            Back to List
        </flux:button>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <flux:card class="dark:bg-zinc-950 p-5!">
            <p class="text-xs text-zinc-500 uppercase tracking-wide mb-1">Total Clicks</p>
            <p class="text-3xl font-bold">{{ number_format($shortUrl->click_count) }}</p>
        </flux:card>

        <flux:card class="dark:bg-zinc-950 p-5!">
            <p class="text-xs text-zinc-500 uppercase tracking-wide mb-1">Max Views</p>
            <p class="text-3xl font-bold">{{ $shortUrl->max_views ? number_format($shortUrl->max_views) : '∞' }}</p>
        </flux:card>

        <flux:card class="dark:bg-zinc-950 p-5!">
            <p class="text-xs text-zinc-500 uppercase tracking-wide mb-1">Created</p>
            <p class="text-lg font-semibold">{{ $shortUrl->created_at->format('M d, Y') }}</p>
        </flux:card>

        <flux:card class="dark:bg-zinc-950 p-5!">
            <p class="text-xs text-zinc-500 uppercase tracking-wide mb-1">Expires</p>
            <p class="text-lg font-semibold">{{ $shortUrl->expires_at?->format('M d, Y') ?? 'Never' }}</p>
        </flux:card>
    </div>

    {{-- Original URL --}}
    <flux:card class="dark:bg-zinc-950">
        <flux:heading size="sm" class="mb-2">Original URL</flux:heading>
        <a href="{{ $shortUrl->original_url }}" target="_blank" rel="noopener" class="text-blue-600 dark:text-blue-400 hover:underline break-all">
            {{ $shortUrl->original_url }}
        </a>
    </flux:card>

    {{-- Chart --}}
    <flux:card class="dark:bg-zinc-950">
        <flux:heading size="lg" class="mb-4">Clicks Over Time (Last 30 Days)</flux:heading>
        <div class="h-64">
            @if (collect($this->chartData)->sum('views') > 0)
                <flux:chart :value="$this->chartData" class="h-full">
                    <flux:chart.svg>
                        <flux:chart.axis y position="left" />
                        <flux:chart.axis x field="label" />
                        <flux:chart.area field="views" class="text-indigo-500/30" />
                        <flux:chart.line field="views" class="text-indigo-500" />
                    </flux:chart.svg>
                    <flux:chart.cursor />
                    <flux:chart.tooltip>
                        <flux:chart.tooltip.heading field="label" />
                        <flux:chart.tooltip.value field="views" label="Clicks" />
                    </flux:chart.tooltip>
                </flux:chart>
            @else
                <div class="h-full flex flex-col items-center justify-center text-zinc-400 dark:text-zinc-500">
                    <flux:icon name="chart-bar" class="size-12 mb-3 opacity-50" />
                    <p class="text-sm font-medium">No click data yet</p>
                    <p class="text-xs mt-1">Data will appear once visitors click the link</p>
                </div>
            @endif
        </div>
    </flux:card>

    {{-- Stats Breakdown --}}
    <div class="grid lg:grid-cols-3 gap-4">
        {{-- Browsers --}}
        <flux:card class="dark:bg-zinc-950">
            <flux:heading size="sm" class="mb-4">Browsers</flux:heading>
            @forelse ($this->browserStats as $browser => $count)
                <div class="flex items-center justify-between py-2 border-b border-zinc-100 dark:border-zinc-800 last:border-0">
                    <span class="text-sm">{{ $browser ?: 'Unknown' }}</span>
                    <flux:badge size="sm">{{ number_format($count) }}</flux:badge>
                </div>
            @empty
                <p class="text-sm text-zinc-500 text-center py-4">No data yet</p>
            @endforelse
        </flux:card>

        {{-- Devices --}}
        <flux:card class="dark:bg-zinc-950">
            <flux:heading size="sm" class="mb-4">Devices</flux:heading>
            @forelse ($this->deviceStats as $device => $count)
                <div class="flex items-center justify-between py-2 border-b border-zinc-100 dark:border-zinc-800 last:border-0">
                    <span class="text-sm">{{ $device ?: 'Unknown' }}</span>
                    <flux:badge size="sm">{{ number_format($count) }}</flux:badge>
                </div>
            @empty
                <p class="text-sm text-zinc-500 text-center py-4">No data yet</p>
            @endforelse
        </flux:card>

        {{-- Platforms --}}
        <flux:card class="dark:bg-zinc-950">
            <flux:heading size="sm" class="mb-4">Platforms</flux:heading>
            @forelse ($this->platformStats as $platform => $count)
                <div class="flex items-center justify-between py-2 border-b border-zinc-100 dark:border-zinc-800 last:border-0">
                    <span class="text-sm">{{ $platform ?: 'Unknown' }}</span>
                    <flux:badge size="sm">{{ number_format($count) }}</flux:badge>
                </div>
            @empty
                <p class="text-sm text-zinc-500 text-center py-4">No data yet</p>
            @endforelse
        </flux:card>
    </div>

    {{-- Recent Visits Table --}}
    <flux:card class="dark:bg-zinc-950 overflow-x-auto">
        <flux:heading size="lg" class="mb-4">Recent Visits</flux:heading>
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Time</flux:table.column>
                <flux:table.column class="hidden sm:table-cell">IP Address</flux:table.column>
                <flux:table.column>Device</flux:table.column>
                <flux:table.column>Browser</flux:table.column>
                <flux:table.column class="hidden md:table-cell">Platform</flux:table.column>
                <flux:table.column class="hidden lg:table-cell">Referer</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($this->recentVisits as $visit)
                    <flux:table.row wire:key="visit-{{ $visit->id }}">
                        <flux:table.cell>{{ $visit->created_at->diffForHumans() }}</flux:table.cell>
                        <flux:table.cell class="hidden sm:table-cell">
                            <span class="font-mono text-xs">{{ $visit->ip_address }}</span>
                        </flux:table.cell>
                        <flux:table.cell>{{ $visit->device }}</flux:table.cell>
                        <flux:table.cell>{{ $visit->browser }}</flux:table.cell>
                        <flux:table.cell class="hidden md:table-cell">{{ $visit->platform }}</flux:table.cell>
                        <flux:table.cell class="hidden lg:table-cell">
                            @if ($visit->referer)
                                <span class="max-w-32 truncate block" title="{{ $visit->referer }}">
                                    {{ Str::limit($visit->referer, 30) }}
                                </span>
                            @else
                                <span class="text-zinc-400">Direct</span>
                            @endif
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="6" class="text-center py-8">
                            <flux:icon name="cursor-arrow-rays" class="size-12 mx-auto mb-2 text-zinc-400" />
                            <p class="text-zinc-500">No visits recorded yet</p>
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>
</div>

@script
<script>
    $wire.on('copy-to-clipboard', ({ url }) => {
        navigator.clipboard.writeText(url);
    });
</script>
@endscript
