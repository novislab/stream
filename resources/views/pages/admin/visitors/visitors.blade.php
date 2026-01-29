<div class="space-y-6">
    {{-- Breadcrumbs --}}
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}" icon="home" />
        <flux:breadcrumbs.item separator="slash">Visitors</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    {{-- Header --}}
    <div>
        <flux:heading size="xl">Visitors</flux:heading>
        <flux:text class="text-zinc-500 dark:text-zinc-400">View all visitor activity on your site</flux:text>
    </div>

    {{-- Table --}}
    <flux:card class="overflow-hidden p-0! dark:bg-zinc-950">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
                    <tr>
                        <th class="px-4 py-3 font-medium text-zinc-600 dark:text-zinc-400">Page</th>
                        <th class="px-4 py-3 font-medium text-zinc-600 dark:text-zinc-400 hidden sm:table-cell">IP Address</th>
                        <th class="px-4 py-3 font-medium text-zinc-600 dark:text-zinc-400 hidden md:table-cell">Device</th>
                        <th class="px-4 py-3 font-medium text-zinc-600 dark:text-zinc-400 hidden lg:table-cell">Browser</th>
                        <th class="px-4 py-3 font-medium text-zinc-600 dark:text-zinc-400 hidden lg:table-cell">Referer</th>
                        <th class="px-4 py-3 font-medium text-zinc-600 dark:text-zinc-400">Visited</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($visitors as $visitor)
                        <tr wire:key="visitor-{{ $visitor['id'] }}" class="hover:bg-zinc-50 dark:hover:bg-zinc-900/50 transition-colors">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <flux:icon name="globe-alt" class="size-4 text-zinc-400 shrink-0" />
                                    <span class="truncate max-w-48" title="{{ $visitor['full_url'] }}">{{ $visitor['url'] }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 hidden sm:table-cell">
                                <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-xs dark:bg-zinc-800">{{ $visitor['ip'] }}</code>
                            </td>
                            <td class="px-4 py-3 hidden md:table-cell">
                                <div class="flex items-center gap-2">
                                    @if($visitor['device'] === 'Mobile')
                                        <flux:icon name="device-phone-mobile" class="size-4 text-zinc-400" />
                                    @elseif($visitor['device'] === 'Tablet')
                                        <flux:icon name="device-tablet" class="size-4 text-zinc-400" />
                                    @else
                                        <flux:icon name="computer-desktop" class="size-4 text-zinc-400" />
                                    @endif
                                    <span>{{ $visitor['device'] }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 hidden lg:table-cell">{{ $visitor['browser'] }}</td>
                            <td class="px-4 py-3 hidden lg:table-cell">
                                <span class="text-zinc-500">{{ $visitor['referer'] }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-zinc-500" title="{{ $visitor['created_at_full'] }}">{{ $visitor['created_at'] }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <flux:icon name="eye-slash" class="mx-auto size-10 text-zinc-300 dark:text-zinc-600 mb-3" />
                                <p class="text-zinc-500">No visitors yet</p>
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
                                        <div class="h-4 w-32 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 hidden sm:table-cell">
                                    <div class="h-5 w-24 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                </td>
                                <td class="px-4 py-3 hidden md:table-cell">
                                    <div class="h-4 w-16 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                </td>
                                <td class="px-4 py-3 hidden lg:table-cell">
                                    <div class="h-4 w-20 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
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
