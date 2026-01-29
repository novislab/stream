<div class="space-y-6" wire:init="loadData">
    @if(!$loaded)
        {{-- Skeleton Metrics Cards --}}
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
            @for($i = 0; $i < 4; $i++)
                <flux:card class="p-5! dark:bg-zinc-950">
                    <flux:skeleton.group animate="shimmer">
                        <flux:skeleton.line class="w-1/3 mb-3" />
                        <flux:skeleton.line class="w-2/3 h-8" />
                    </flux:skeleton.group>
                </flux:card>
            @endfor
        </div>

        {{-- Skeleton Analytics Chart --}}
        <flux:card class="p-4! sm:p-6! dark:bg-zinc-950">
            <flux:skeleton.group animate="shimmer">
                <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <flux:skeleton.line class="w-32 h-6 mb-2" />
                        <flux:skeleton.line class="w-48" />
                    </div>
                    <flux:skeleton class="w-48 sm:w-64 h-10 rounded-lg" />
                </div>
                <flux:skeleton class="h-64 w-full rounded-lg" />
            </flux:skeleton.group>
        </flux:card>

        {{-- Skeleton Middle Row --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach([0, 1, 2] as $i)
                <flux:card class="p-4! sm:p-5! dark:bg-zinc-950 {{ $loop->last ? 'sm:col-span-2 lg:col-span-1' : '' }}">
                    <flux:skeleton.group animate="shimmer">
                        <flux:skeleton.line class="w-1/3 mb-4" />
                        <flux:skeleton.line class="mb-2" />
                        <flux:skeleton.line class="mb-2" />
                        <flux:skeleton.line class="mb-2" />
                        <flux:skeleton.line class="w-3/4" />
                    </flux:skeleton.group>
                </flux:card>
            @endforeach
        </div>

        {{-- Skeleton Bottom Row --}}
        <div class="grid gap-4 lg:grid-cols-2">
            <flux:card class="p-4! sm:p-5! dark:bg-zinc-950">
                <flux:skeleton.group animate="shimmer">
                    <flux:skeleton.line class="w-1/3 mb-4" />
                    <flux:skeleton class="h-48 w-full rounded-lg" />
                </flux:skeleton.group>
            </flux:card>
            <flux:card class="p-4! sm:p-5! dark:bg-zinc-950">
                <flux:skeleton.group animate="shimmer">
                    <flux:skeleton.line class="w-1/3 mb-4" />
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-6 sm:gap-8">
                        <flux:skeleton class="size-32 sm:size-40 rounded-full" />
                        <div class="flex sm:block gap-4 sm:space-y-3">
                            <flux:skeleton.line class="w-16 sm:w-24" />
                            <flux:skeleton.line class="w-16 sm:w-24" />
                            <flux:skeleton.line class="w-16 sm:w-24" />
                        </div>
                    </div>
                </flux:skeleton.group>
            </flux:card>
        </div>
    @else
        {{-- Metrics Cards --}}
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
            @foreach($stats as $stat)
                <x-admin.metric-card
                    :title="$stat['title']"
                    :value="$stat['value']"
                    :change="$stat['change']"
                    :change-type="$stat['changeType']"
                />
            @endforeach
        </div>

        {{-- Analytics Chart --}}
        <flux:card class="p-4! sm:p-6! dark:bg-zinc-950">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <flux:heading size="lg">Analytics</flux:heading>
                    <flux:text class="text-zinc-500 dark:text-zinc-400">Visitor analytics of last {{ $chartPeriod === 'monthly' ? '30' : ($chartPeriod === 'quarterly' ? '90' : '365') }} days</flux:text>
                </div>
                <div class="flex gap-1 rounded-lg bg-zinc-100 p-1 dark:bg-zinc-800 self-start sm:self-auto">
                    <button
                        wire:click="setChartPeriod('monthly')"
                        wire:loading.attr="disabled"
                        wire:target="setChartPeriod"
                        @class([
                            'rounded-md px-3 sm:px-4 py-1.5 text-sm font-medium transition-colors disabled:opacity-50',
                            'bg-white text-zinc-900 shadow-sm dark:bg-zinc-700 dark:text-white' => $chartPeriod === 'monthly',
                            'text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white' => $chartPeriod !== 'monthly',
                        ])
                    >Monthly</button>
                    <button
                        wire:click="setChartPeriod('quarterly')"
                        wire:loading.attr="disabled"
                        wire:target="setChartPeriod"
                        @class([
                            'rounded-md px-3 sm:px-4 py-1.5 text-sm font-medium transition-colors disabled:opacity-50',
                            'bg-white text-zinc-900 shadow-sm dark:bg-zinc-700 dark:text-white' => $chartPeriod === 'quarterly',
                            'text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white' => $chartPeriod !== 'quarterly',
                        ])
                    >Quarterly</button>
                    <button
                        wire:click="setChartPeriod('annually')"
                        wire:loading.attr="disabled"
                        wire:target="setChartPeriod"
                        @class([
                            'rounded-md px-3 sm:px-4 py-1.5 text-sm font-medium transition-colors disabled:opacity-50',
                            'bg-white text-zinc-900 shadow-sm dark:bg-zinc-700 dark:text-white' => $chartPeriod === 'annually',
                            'text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white' => $chartPeriod !== 'annually',
                        ])
                    >Annually</button>
                </div>
            </div>
            <div class="h-64 relative" wire:key="chart-{{ $chartPeriod }}">
                <div wire:loading wire:target="setChartPeriod" class="absolute inset-0 z-10">
                    <flux:skeleton class="h-full w-full rounded-lg" animate="shimmer" />
                </div>
                @php
                    $hasData = collect($this->chartData)->sum('views') > 0;
                @endphp
                @if($hasData)
                    <flux:chart wire:loading.remove wire:target="setChartPeriod" :value="$this->chartData" class="h-full">
                        <flux:chart.svg>
                            <flux:chart.axis y position="left" />
                            <flux:chart.axis x field="label" />
                            <flux:chart.area field="views" class="text-indigo-500/30" />
                            <flux:chart.line field="views" class="text-indigo-500" />
                        </flux:chart.svg>
                        <flux:chart.cursor />
                        <flux:chart.tooltip>
                            <flux:chart.tooltip.heading field="label" />
                            <flux:chart.tooltip.value field="views" label="Views" />
                        </flux:chart.tooltip>
                    </flux:chart>
                @else
                    <div wire:loading.remove wire:target="setChartPeriod" class="h-full flex flex-col items-center justify-center text-zinc-400 dark:text-zinc-500">
                        <flux:icon name="chart-bar" class="size-12 mb-3 opacity-50" />
                        <p class="text-sm font-medium">No visitor data yet</p>
                        <p class="text-xs mt-1">Analytics will appear once visitors arrive</p>
                    </div>
                @endif
            </div>
        </flux:card>

        {{-- Middle Row - Top Pages & Active Users --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            {{-- Top Pages --}}
            <flux:card class="p-4! sm:p-5! dark:bg-zinc-950">
                <div class="mb-4 flex items-center justify-between">
                    <div class="min-w-0 flex-1">
                        <flux:heading>Top Pages</flux:heading>
                        <div class="mt-1 flex justify-between text-xs text-zinc-500">
                            <span>Source</span>
                            <span>Pageviews</span>
                        </div>
                    </div>
                    <flux:dropdown>
                        <flux:button variant="ghost" size="sm" icon="ellipsis-vertical" wire:loading.attr="disabled" wire:target="refreshTopPages" />
                        <flux:menu>
                            <flux:menu.item icon="arrow-path" wire:click="refreshTopPages">Refresh</flux:menu.item>
                        </flux:menu>
                    </flux:dropdown>
                </div>
                <div class="space-y-3">
                    <div wire:loading wire:target="refreshTopPages">
                        <flux:skeleton.group animate="shimmer">
                            @for($i = 0; $i < 5; $i++)
                                <div class="flex items-center justify-between rounded-lg bg-zinc-100 p-3 dark:bg-zinc-800/50 mb-3">
                                    <div class="flex items-center gap-3">
                                        <flux:skeleton class="size-9 rounded-lg" />
                                        <flux:skeleton.line class="w-24" />
                                    </div>
                                    <flux:skeleton.line class="w-10" />
                                </div>
                            @endfor
                        </flux:skeleton.group>
                    </div>
                    <div wire:loading.remove wire:target="refreshTopPages" class="space-y-3">
                        @forelse($this->topPages as $page)
                            <div class="flex items-center justify-between rounded-lg bg-zinc-100 p-3 dark:bg-zinc-800/50">
                                <div class="flex items-center gap-3">
                                    <div class="rounded-lg bg-indigo-500/20 p-2">
                                        <flux:icon name="globe-alt" class="size-5 text-indigo-500 dark:text-indigo-400" />
                                    </div>
                                    <span class="text-xs truncate max-w-36 sm:max-w-40">{{ $page['url'] }}</span>
                                </div>
                                <span class="text-sm font-semibold">{{ number_format($page['views']) }}</span>
                            </div>
                        @empty
                            <div class="text-center text-zinc-500 py-4">
                                <flux:icon name="chart-bar" class="mx-auto size-8 mb-2 opacity-50" />
                                <p class="text-sm">No page views yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </flux:card>

            {{-- Active Users --}}
            <flux:card class="p-4! sm:p-5! dark:bg-zinc-950">
                <div class="mb-4 flex items-center justify-between">
                    <flux:heading>Active Users</flux:heading>
                    <flux:dropdown>
                        <flux:button variant="ghost" size="sm" icon="ellipsis-vertical" wire:loading.attr="disabled" wire:target="refreshActiveUsers" />
                        <flux:menu>
                            <flux:menu.item icon="arrow-path" wire:click="refreshActiveUsers">Refresh</flux:menu.item>
                        </flux:menu>
                    </flux:dropdown>
                </div>
                <div>
                    <div wire:loading wire:target="refreshActiveUsers">
                        <flux:skeleton.group animate="shimmer">
                            <div class="flex items-center gap-2 mb-4">
                                <flux:skeleton class="size-2 rounded-full" />
                                <flux:skeleton.line class="w-12 h-8" />
                                <flux:skeleton.line class="w-20" />
                            </div>
                            <flux:skeleton class="h-20 w-full rounded-lg mb-4" />
                            <div class="grid grid-cols-3 gap-4 text-center">
                                <div>
                                    <flux:skeleton.line class="w-12 h-6 mx-auto mb-1" />
                                    <flux:skeleton.line class="w-16 mx-auto" />
                                </div>
                                <div>
                                    <flux:skeleton.line class="w-12 h-6 mx-auto mb-1" />
                                    <flux:skeleton.line class="w-16 mx-auto" />
                                </div>
                                <div>
                                    <flux:skeleton.line class="w-12 h-6 mx-auto mb-1" />
                                    <flux:skeleton.line class="w-16 mx-auto" />
                                </div>
                            </div>
                        </flux:skeleton.group>
                    </div>
                    <div wire:loading.remove wire:target="refreshActiveUsers">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="size-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-3xl font-bold">{{ number_format($this->liveVisitors) }}</span>
                            <span class="text-zinc-500 text-sm">Live visitors</span>
                        </div>
                        <div class="h-20 mb-4">
                            @if($hasData ?? collect($this->chartData)->sum('views') > 0)
                                <flux:chart :value="$this->chartData" class="h-full">
                                    <flux:chart.svg>
                                        <flux:chart.line field="views" class="text-indigo-500" />
                                    </flux:chart.svg>
                                </flux:chart>
                            @else
                                <div class="h-full flex items-center justify-center border border-dashed border-zinc-200 dark:border-zinc-700 rounded-lg">
                                    <span class="text-xs text-zinc-400">No activity data</span>
                                </div>
                            @endif
                        </div>
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div>
                                <p class="text-lg font-semibold">{{ number_format($this->todayVisitors) }}</p>
                                <p class="text-xs text-zinc-500">Avg. Daily</p>
                            </div>
                            <div>
                                <p class="text-lg font-semibold">{{ number_format($this->thisWeekVisitors) }}</p>
                                <p class="text-xs text-zinc-500">Avg. Weekly</p>
                            </div>
                            <div>
                                <p class="text-lg font-semibold">{{ number_format($this->thisMonthVisitors) }}</p>
                                <p class="text-xs text-zinc-500">Avg. Monthly</p>
                            </div>
                        </div>
                    </div>
                </div>
            </flux:card>

            {{-- Visitor Stats --}}
            <flux:card class="p-4! sm:p-5! dark:bg-zinc-950 sm:col-span-2 lg:col-span-1">
                <div class="mb-4 flex items-center justify-between">
                    <flux:heading>Visitor Stats</flux:heading>
                    <flux:dropdown>
                        <flux:button variant="ghost" size="sm" icon="ellipsis-vertical" wire:loading.attr="disabled" wire:target="refreshVisitorStats" />
                        <flux:menu>
                            <flux:menu.item icon="arrow-path" wire:click="refreshVisitorStats">Refresh</flux:menu.item>
                        </flux:menu>
                    </flux:dropdown>
                </div>
                <div class="space-y-4">
                    <div wire:loading wire:target="refreshVisitorStats">
                        <flux:skeleton.group animate="shimmer">
                            @for($i = 0; $i < 3; $i++)
                                <div class="flex items-center justify-between rounded-lg bg-zinc-100 p-3 dark:bg-zinc-800/50 mb-4">
                                    <div class="flex items-center gap-3">
                                        <flux:skeleton class="size-9 rounded-lg" />
                                        <flux:skeleton.line class="w-24" />
                                    </div>
                                    <flux:skeleton.line class="w-12 h-6" />
                                </div>
                            @endfor
                        </flux:skeleton.group>
                    </div>
                    <div wire:loading.remove wire:target="refreshVisitorStats" class="space-y-4">
                        <div class="flex items-center justify-between rounded-lg bg-zinc-100 p-3 dark:bg-zinc-800/50">
                            <div class="flex items-center gap-3">
                                <div class="rounded-lg bg-blue-500/20 p-2">
                                    <flux:icon name="eye" class="size-5 text-blue-500 dark:text-blue-400" />
                                </div>
                                <span class="text-sm">Today's Views</span>
                            </div>
                            <span class="text-lg font-semibold">{{ number_format($this->todayVisitors) }}</span>
                        </div>
                        <div class="flex items-center justify-between rounded-lg bg-zinc-100 p-3 dark:bg-zinc-800/50">
                            <div class="flex items-center gap-3">
                                <div class="rounded-lg bg-green-500/20 p-2">
                                    <flux:icon name="calendar" class="size-5 text-green-500 dark:text-green-400" />
                                </div>
                                <span class="text-sm">This Week</span>
                            </div>
                            <span class="text-lg font-semibold">{{ number_format($this->thisWeekVisitors) }}</span>
                        </div>
                        <div class="flex items-center justify-between rounded-lg bg-zinc-100 p-3 dark:bg-zinc-800/50">
                            <div class="flex items-center gap-3">
                                <div class="rounded-lg bg-purple-500/20 p-2">
                                    <flux:icon name="chart-bar" class="size-5 text-purple-500 dark:text-purple-400" />
                                </div>
                                <span class="text-sm">This Month</span>
                            </div>
                            <span class="text-lg font-semibold">{{ number_format($this->thisMonthVisitors) }}</span>
                        </div>
                    </div>
                </div>
            </flux:card>
        </div>

        {{-- Bottom Row - Acquisition Channels & Sessions By Device --}}
        <div class="grid gap-4 lg:grid-cols-2">
            {{-- Acquisition Channels --}}
            <flux:card class="p-4! sm:p-5! dark:bg-zinc-950">
                <div class="mb-4 flex items-center justify-between">
                    <flux:heading>Acquisition Channels</flux:heading>
                    <flux:dropdown>
                        <flux:button variant="ghost" size="sm" icon="ellipsis-vertical" wire:loading.attr="disabled" wire:target="refreshChannels" />
                        <flux:menu>
                            <flux:menu.item icon="arrow-path" wire:click="refreshChannels">Refresh</flux:menu.item>
                        </flux:menu>
                    </flux:dropdown>
                </div>
                <div class="grid grid-cols-2 sm:flex sm:flex-wrap gap-2 sm:gap-4 mb-4 text-xs">
                    <div class="flex items-center gap-2">
                        <span class="size-3 shrink-0 rounded-full bg-blue-600"></span>
                        <span>Direct</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="size-3 shrink-0 rounded-full bg-blue-400"></span>
                        <span>Referral</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="size-3 shrink-0 rounded-full bg-blue-300"></span>
                        <span>Organic</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="size-3 shrink-0 rounded-full bg-blue-200"></span>
                        <span>Social</span>
                    </div>
                </div>
                <div class="h-48 relative">
                    <div wire:loading wire:target="refreshChannels" class="absolute inset-0 z-10">
                        <flux:skeleton class="h-full w-full rounded-lg" animate="shimmer" />
                    </div>
                    @php
                        $hasChannelData = collect($this->channelsData)->sum(fn($d) => $d['direct'] + $d['referral'] + $d['organic'] + $d['social']) > 0;
                    @endphp
                    @if($hasChannelData)
                        <flux:chart wire:loading.remove wire:target="refreshChannels" :value="$this->channelsData" class="h-full">
                            <flux:chart.svg>
                                <flux:chart.axis y position="left" />
                                <flux:chart.axis x field="label" />
                                <flux:chart.area field="direct" class="text-blue-600/80" curve="step" />
                                <flux:chart.area field="referral" class="text-blue-400/80" curve="step" />
                                <flux:chart.area field="organic" class="text-blue-300/80" curve="step" />
                                <flux:chart.area field="social" class="text-blue-200/80" curve="step" />
                            </flux:chart.svg>
                            <flux:chart.cursor />
                            <flux:chart.tooltip>
                                <flux:chart.tooltip.heading field="label" />
                                <flux:chart.tooltip.value field="direct" label="Direct" />
                                <flux:chart.tooltip.value field="referral" label="Referral" />
                                <flux:chart.tooltip.value field="organic" label="Organic" />
                                <flux:chart.tooltip.value field="social" label="Social" />
                            </flux:chart.tooltip>
                        </flux:chart>
                    @else
                        <div wire:loading.remove wire:target="refreshChannels" class="h-full flex flex-col items-center justify-center text-zinc-400 dark:text-zinc-500">
                            <flux:icon name="signal" class="size-10 mb-2 opacity-50" />
                            <p class="text-sm">No channel data yet</p>
                        </div>
                    @endif
                </div>
            </flux:card>

            {{-- Sessions By Device --}}
            <flux:card class="p-4! sm:p-5! dark:bg-zinc-950">
                <div class="mb-4 flex items-center justify-between">
                    <flux:heading>Sessions By Device</flux:heading>
                    <flux:dropdown>
                        <flux:button variant="ghost" size="sm" icon="ellipsis-vertical" wire:loading.attr="disabled" wire:target="refreshDevices" />
                        <flux:menu>
                            <flux:menu.item icon="arrow-path" wire:click="refreshDevices">Refresh</flux:menu.item>
                        </flux:menu>
                    </flux:dropdown>
                </div>
                <div class="flex items-center justify-center">
                    <div wire:loading wire:target="refreshDevices" class="flex flex-col sm:flex-row items-center justify-center gap-6 sm:gap-8">
                        <flux:skeleton.group animate="shimmer">
                            <flux:skeleton class="size-32 sm:size-40 rounded-full" />
                            <div class="flex sm:block gap-4 sm:space-y-3 mt-4 sm:mt-0">
                                @for($i = 0; $i < 3; $i++)
                                    <div class="flex items-center gap-2 sm:gap-3">
                                        <flux:skeleton class="size-3 rounded-full" />
                                        <div>
                                            <flux:skeleton.line class="w-12 sm:w-16 mb-1" />
                                            <flux:skeleton.line class="w-8 sm:w-10" />
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </flux:skeleton.group>
                    </div>
                    <div wire:loading.remove wire:target="refreshDevices" class="flex flex-col sm:flex-row items-center justify-center gap-6 sm:gap-8">
                        {{-- Donut Chart --}}
                        <div class="relative">
                            @php
                                $devices = $this->deviceData;
                                $total = array_sum(array_column($devices, 'value'));
                                $colors = ['#6366f1', '#22d3ee', '#a855f7'];
                                $offset = 0;
                            @endphp
                            <svg class="size-32 sm:size-40" viewBox="0 0 36 36">
                                @foreach($devices as $index => $device)
                                    @php
                                        $percentage = $total > 0 ? ($device['value'] / $total) * 100 : 0;
                                        $dashArray = $percentage . ' ' . (100 - $percentage);
                                    @endphp
                                    <circle
                                        cx="18" cy="18" r="14"
                                        fill="none"
                                        stroke="{{ $colors[$index] }}"
                                        stroke-width="4"
                                        stroke-dasharray="{{ $dashArray }}"
                                        stroke-dashoffset="{{ -$offset }}"
                                        transform="rotate(-90 18 18)"
                                    />
                                    @php $offset += $percentage; @endphp
                                @endforeach
                                <circle cx="18" cy="18" r="10" class="fill-white dark:fill-zinc-950" />
                            </svg>
                        </div>
                        {{-- Legend --}}
                        <div class="flex sm:block gap-4 sm:space-y-3">
                            @foreach($this->deviceData as $index => $device)
                                <div class="flex items-center gap-2 sm:gap-3">
                                    <span class="size-3 shrink-0 rounded-full" style="background-color: {{ $colors[$index] }}"></span>
                                    <div>
                                        <p class="text-xs sm:text-sm font-medium">{{ $device['label'] }}</p>
                                        <p class="text-xs text-zinc-500">{{ $device['percentage'] }}%</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </flux:card>
        </div>
    @endif
</div>
