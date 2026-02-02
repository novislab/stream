<?php

declare(strict_types=1);

use App\Models\Setting;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

new #[Layout('layouts::admin')] #[Title('Admin Bank')] class extends Component
{
    #[Validate('required|string|max:255')]
    public string $bank = '';

    #[Validate('required|string|max:255')]
    public string $accountName = '';

    #[Validate('required|string|max:255')]
    public string $accountNumber = '';

    public function mount(): void
    {
        $this->bank = Setting::get('bank', '');
        $this->accountName = Setting::get('bank_account_name', '');
        $this->accountNumber = Setting::get('bank_account_number', '');
    }

    public function save(): void
    {
        $this->validate();

        Setting::set('bank', $this->bank);
        Setting::set('bank_account_name', $this->accountName);
        Setting::set('bank_account_number', $this->accountNumber);

        Flux::toast('Bank details saved successfully.');
    }
};
