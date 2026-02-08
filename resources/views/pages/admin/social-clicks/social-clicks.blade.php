<div class="space-y-6">
    {{-- Breadcrumbs --}}
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}" icon="home" />
        <flux:breadcrumbs.item separator="slash">Social Clicks</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    {{-- Header --}}
    <div>
        <flux:heading size="xl">Social Clicks</flux:heading>
        <flux:text class="text-zinc-500 dark:text-zinc-400">Track clicks on your social media links</flux:text>
    </div>

    {{-- Stats Cards --}}
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
        <flux:card class="p-4 dark:bg-zinc-950">
            <flux:heading size="lg">{{ number_format($this->totalClicks) }}</flux:heading>
            <flux:text class="text-zinc-500 dark:text-zinc-400">Total Clicks</flux:text>
        </flux:card>
        @foreach($this->clicksByPlatform as $platform)
            <flux:card class="p-4 dark:bg-zinc-950">
                <flux:heading size="lg">{{ number_format($platform['click_count']) }}</flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400 capitalize">{{ $platform['platform'] }}</flux:text>
            </flux:card>
        @endforeach
    </div>

    {{-- Social Links Summary --}}
    <flux:card class="dark:bg-zinc-950">
        <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
            <flux:heading size="md">Social Links Performance</flux:heading>
        </div>
        <div class="p-4">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($this->socialLinks as $link)
                    <div class="rounded-lg bg-zinc-50 p-4 dark:bg-zinc-800/50">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-semibold capitalize">{{ $link['platform'] }}</span>
                            <span class="text-sm text-zinc-500">{{ $link['click_count'] }} clicks</span>
                        </div>
                        <p class="text-xs text-zinc-400 truncate">{{ $link['url'] }}</p>
                    </div>
                @empty
                    <p class="text-zinc-500 col-span-3 text-center py-4">No social links configured</p>
                @endforelse
            </div>
        </div>
    </flux:card>

    {{-- Clicks Table --}}
    <flux:card class="overflow-hidden p-0! dark:bg-zinc-950">
        <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
            <flux:heading size="md">Recent Clicks</flux:heading>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
                    <tr>
                        <th class="px-4 py-3 font-medium text-zinc-600 dark:text-zinc-400">Platform</th>
                        <th class="px-4 py-3 font-medium text-zinc-600 dark:text-zinc-400 hidden sm:table-cell">IP Address</th>
                        <th class="px-4 py-3 font-medium text-zinc-600 dark:text-zinc-400 hidden md:table-cell">User Agent</th>
                        <th class="px-4 py-3 font-medium text-zinc-600 dark:text-zinc-400 hidden lg:table-cell">Referer</th>
                        <th class="px-4 py-3 font-medium text-zinc-600 dark:text-zinc-400">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($this->socialClicks as $click)
                        <tr wire:key="click-{{ $click['id'] }}" class="hover:bg-zinc-50 dark:hover:bg-zinc-900/50 transition-colors">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <flux:icon name="share" class="size-4 text-zinc-400" />
                                    <span class="font-medium capitalize">{{ $click['platform'] }}</span>
                                </div>
                                <p class="text-xs text-zinc-400 truncate max-w-48 mt-1 sm:hidden">{{ $click['url'] }}</p>
                            </td>
                            <td class="px-4 py-3 hidden sm:table-cell">
                                <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-xs dark:bg-zinc-800">{{ $click['ip_address'] }}</code>
                            </td>
                            <td class="px-4 py-3 hidden md:table-cell">
                                <span class="text-zinc-500 truncate max-w-48" title="{{ $click['user_agent'] }}">{{ $click['user_agent'] }}</span>
                            </td>
                            <td class="px-4 py-3 hidden lg:table-cell">
                                <span class="text-zinc-500">{{ $click['referer'] }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-zinc-500" title="{{ $click['created_at_full'] }}">{{ $click['created_at'] }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center">
                                <flux:icon name="share" class="mx-auto size-10 text-zinc-300 dark:text-zinc-600 mb-3" />
                                <p class="text-zinc-500">No clicks yet</p>
                            </td>
                        </tr>
                    @endforelse

                    {{-- Skeleton rows for infinite scroll --}}
                    @if($hasMore)
                        @for($i = 0; $i < 5; $i++)
                            <tr
                                @if($i === 0) wire:intersect="loadMore" @endif
                                class="animate-pulse"
                            >
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="size-4 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                        <div class="h-4 w-20 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 hidden sm:table-cell">
                                    <div class="h-5 w-24 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                </td>
                                <td class="px-4 py-3 hidden md:table-cell">
                                    <div class="h-4 w-32 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                </td>
                                <td class="px-4 py-3 hidden lg:table-cell">
                                    <div class="h-4 w-24 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="h-4 w-20 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                </td>
                            </tr>
                        @endfor
                    @endif
                </tbody>
            </table>
        </div>
    </flux:card>
</div>
