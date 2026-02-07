<?php

use App\Models\Bank;
use Flux\Flux;
use Livewire\Component;

new class extends Component
{
    public $banks;

    public function mount(): void
    {
        $this->banks = Bank::where('is_active', true)->get();
    }

    public function makePayment(): void
    {
        Flux::toast('Payment processing initiated. Please complete the bank transfer.');
    }
};
