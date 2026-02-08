<div class="space-y-6">
    {{-- Breadcrumbs --}}
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}" icon="home" />
        <flux:breadcrumbs.item separator="slash">Payments</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    {{-- Header --}}
    <div>
        <flux:heading size="xl">Payments</flux:heading>
        <flux:text class="text-zinc-500 dark:text-zinc-400">View all payment transactions</flux:text>
    </div>

    {{-- Stats Cards --}}
    <div class="grid gap-4 md:grid-cols-4">
        <flux:card class="p-4 dark:bg-zinc-950">
            <flux:heading size="lg">{{ number_format($this->totalPayments) }}</flux:heading>
            <flux:text class="text-zinc-500 dark:text-zinc-400">Total Payments</flux:text>
        </flux:card>
        <flux:card class="p-4 dark:bg-zinc-950">
            <flux:heading size="lg">{{ number_format($this->completedPayments) }}</flux:heading>
            <flux:text class="text-zinc-500 dark:text-zinc-400">Completed</flux:text>
        </flux:card>
        <flux:card class="p-4 dark:bg-zinc-950">
            <flux:heading size="lg">{{ number_format($this->pendingPayments) }}</flux:heading>
            <flux:text class="text-zinc-500 dark:text-zinc-400">Pending</flux:text>
        </flux:card>
        <flux:card class="p-4 dark:bg-zinc-950">
            <flux:heading size="lg">₦{{ number_format($this->totalRevenue, 2) }}</flux:heading>
            <flux:text class="text-zinc-500 dark:text-zinc-400">Total Revenue</flux:text>
        </flux:card>
    </div>

    {{-- Table --}}
    <flux:card class="overflow-hidden p-0! dark:bg-zinc-950">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
                    <tr>
                        <th class="px-4 py-3 font-medium text-zinc-600 dark:text-zinc-400">Amount</th>
                        <th class="px-4 py-3 font-medium text-zinc-600 dark:text-zinc-400 hidden sm:table-cell">Status</th>
                        <th class="px-4 py-3 font-medium text-zinc-600 dark:text-zinc-400 hidden md:table-cell">Transaction ID</th>
                        <th class="px-4 py-3 font-medium text-zinc-600 dark:text-zinc-400 hidden lg:table-cell">Bank</th>
                        <th class="px-4 py-3 font-medium text-zinc-600 dark:text-zinc-400 hidden lg:table-cell">Account</th>
                        <th class="px-4 py-3 font-medium text-zinc-600 dark:text-zinc-400">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($this->payments as $payment)
                        <tr wire:key="payment-{{ $payment['id'] }}" class="hover:bg-zinc-50 dark:hover:bg-zinc-900/50 transition-colors">
                            <td class="px-4 py-3">
                                <span class="font-semibold">₦{{ $payment['amount'] }}</span>
                            </td>
                            <td class="px-4 py-3 hidden sm:table-cell">
                                @if($payment['status'] === 'completed')
                                    <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        Completed
                                    </span>
                                @elseif($payment['status'] === 'pending')
                                    <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                        Pending
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                        Failed
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 hidden md:table-cell">
                                <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-xs dark:bg-zinc-800">{{ $payment['transaction_id'] }}</code>
                            </td>
                            <td class="px-4 py-3 hidden lg:table-cell">{{ $payment['bank_name'] }}</td>
                            <td class="px-4 py-3 hidden lg:table-cell">
                                <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-xs dark:bg-zinc-800">{{ $payment['account_number'] }}</code>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-zinc-500" title="{{ $payment['created_at_full'] }}">{{ $payment['created_at'] }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <flux:icon name="banknotes" class="mx-auto size-10 text-zinc-300 dark:text-zinc-600 mb-3" />
                                <p class="text-zinc-500">No payments yet</p>
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
                                    <div class="h-4 w-20 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                </td>
                                <td class="px-4 py-3 hidden sm:table-cell">
                                    <div class="h-6 w-20 bg-zinc-200 dark:bg-zinc-700 rounded-full"></div>
                                </td>
                                <td class="px-4 py-3 hidden md:table-cell">
                                    <div class="h-5 w-32 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                </td>
                                <td class="px-4 py-3 hidden lg:table-cell">
                                    <div class="h-4 w-24 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                </td>
                                <td class="px-4 py-3 hidden lg:table-cell">
                                    <div class="h-5 w-28 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
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
