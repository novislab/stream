<?php

use Livewire\Component;

new class extends Component
{
    public string $fullName = '';

    public string $email = '';

    public string $phone = '';

    public string $referralCode = '';

    public string $activationCode = '';

    public string $password = '';

    public string $passwordConfirmation = '';

    public bool $agreeTerms = false;

    public bool $showInvalidCodeModal = false;

    public function register(): void
    {
        // Show invalid activation code modal
        $this->showInvalidCodeModal = true;
    }

    public function closeModal(): void
    {
        $this->showInvalidCodeModal = false;
    }
};
