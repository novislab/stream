<?php

declare(strict_types=1);

use App\Models\Payment;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts::admin')] #[Title('Admin Payments')] class extends Component
{
    public bool $loaded = false;

    public int $perPage = 20;

    public bool $hasMore = true;

    public function loadMore(): void
    {
        $this->perPage += 20;
        $this->hasMore = Payment::query()->count() > $this->perPage;
    }

    #[Computed]
    public function payments(): array
    {
        return Payment::query()
            ->orderByDesc('created_at')
            ->limit($this->perPage)
            ->get()
            ->map(fn (Payment $payment) => [
                'id' => $payment->id,
                'amount' => number_format((float) $payment->amount, 2),
                'status' => $payment->status,
                'transaction_id' => $payment->transaction_id ?? 'N/A',
                'bank_name' => $payment->bank_name ?? 'N/A',
                'account_number' => $payment->account_number ?? 'N/A',
                'created_at' => $payment->created_at->format('M d, Y'),
                'created_at_full' => $payment->created_at->toISOString(),
            ])
            ->toArray();
    }

    #[Computed]
    public function totalPayments(): int
    {
        return Payment::query()->count();
    }

    #[Computed]
    public function completedPayments(): int
    {
        return Payment::query()->count();
    }

    #[Computed]
    public function pendingPayments(): int
    {
        return Payment::query()->where('status', 'pending')->count();
    }

    #[Computed]
    public function totalRevenue(): float
    {
        return Payment::query()->where('status', 'completed')->sum('amount');
    }
};
