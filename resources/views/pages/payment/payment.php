<?php

use App\Models\Setting;
use Livewire\Component;

new class extends Component
{
    public bool $showProcessingModal = false;

    public ?string $bank = null;

    public ?string $bankAccountName = null;

    public ?string $bankAccountNumber = null;

    public function mount(): void
    {
        $this->bank = Setting::get('bank');
        $this->bankAccountName = Setting::get('bank_account_name');
        $this->bankAccountNumber = Setting::get('bank_account_number');
    }

    public function processPayment(): void
    {
        $this->showProcessingModal = true;
    }
};
