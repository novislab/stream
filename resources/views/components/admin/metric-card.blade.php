@props([
    'title',
    'value',
    'change' => null,
    'changeType' => 'positive',
])

<flux:card class="p-5! dark:bg-zinc-950">
    <flux:text class="text">{{ $title }}</flux:text>
    <div class="mt-2 flex items-baseline gap-3">
        <span class="text-3xl font-bold">{{ $value }}</span>
        @if($change)
            <span @class([
                'rounded px-2 py-0.5 text-xs font-medium',
                'bg-emerald-500/20 text-emerald-400' => $changeType === 'positive',
                'bg-red-500/20 text-red-400' => $changeType === 'negative',
            ])>{{ $change }}</span>
            <span class="text-xs text-zinc-500">Vs last month</span>
        @endif
    </div>
</flux:card>
