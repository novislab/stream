<?php

declare(strict_types=1);

use App\Models\Bank;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

new #[Layout('layouts::admin')] #[Title('Admin Bank')] class extends Component
{
    public $banks;

    public $showAddForm = false;

    // New bank form fields
    #[Validate('required|string|max:255')]
    public string $new_bank_name = '';

    #[Validate('required|string|max:255')]
    public string $new_account_name = '';

    #[Validate('required|string|max:255')]
    public string $new_account_number = '';

    #[Validate('boolean')]
    public bool $new_is_active = true;

    // Array to hold editing states for each bank
    public $editingBanks = [];

    public function mount(): void
    {
        $this->banks = Bank::all();
        $this->initializeEditingBanks();
    }

    public function initializeEditingBanks(): void
    {
        foreach ($this->banks as $bank) {
            $this->editingBanks[$bank->id] = [
                'bank_name' => $bank->bank_name,
                'account_name' => $bank->account_name,
                'account_number' => $bank->account_number,
                'is_active' => $bank->is_active,
            ];
        }
    }

    public function showAddBankForm(): void
    {
        $this->showAddForm = true;
        $this->reset(['new_bank_name', 'new_account_name', 'new_account_number', 'new_is_active']);
    }

    public function hideAddBankForm(): void
    {
        $this->showAddForm = false;
        $this->reset(['new_bank_name', 'new_account_name', 'new_account_number', 'new_is_active']);
    }

    public function saveNewBank(): void
    {
        $this->validate([
            'new_bank_name' => 'required|string|max:255',
            'new_account_name' => 'required|string|max:255',
            'new_account_number' => 'required|string|max:255',
            'new_is_active' => 'boolean',
        ]);

        Bank::create([
            'bank_name' => $this->new_bank_name,
            'account_name' => $this->new_account_name,
            'account_number' => $this->new_account_number,
            'is_active' => $this->new_is_active,
        ]);

        $this->hideAddBankForm();
        $this->banks = Bank::all();
        $this->initializeEditingBanks();
        Flux::toast('Bank added successfully.');
    }

    public function updateBank($id): void
    {
        $bank = Bank::find($id);
        if (! $bank) {
            return;
        }

        $editingData = $this->editingBanks[$id] ?? [];

        $this->validate([
            "editingBanks.{$id}.bank_name" => 'required|string|max:255',
            "editingBanks.{$id}.account_name" => 'required|string|max:255',
            "editingBanks.{$id}.account_number" => 'required|string|max:255',
            "editingBanks.{$id}.is_active" => 'boolean',
        ]);

        $bank->update($editingData);
        $this->banks = Bank::all();
        $this->initializeEditingBanks();
        Flux::toast('Bank updated successfully.');
    }

    public function deleteBank($id): void
    {
        $bank = Bank::find($id);
        if ($bank) {
            $bank->delete();
            unset($this->editingBanks[$id]);
            $this->banks = Bank::all();
            Flux::toast('Bank deleted successfully.');
        }
    }

    public function resetBank($id): void
    {
        $bank = Bank::find($id);
        if ($bank) {
            $this->editingBanks[$id] = [
                'bank_name' => $bank->bank_name,
                'account_name' => $bank->account_name,
                'account_number' => $bank->account_number,
                'is_active' => $bank->is_active,
            ];
            Flux::toast('Bank reset to original values.');
        }
    }
};
