<?php

use Livewire\Component;

new class extends Component
{
    public bool $showProcessingModal = false;

    public function processPayment(): void
    {
        $this->showProcessingModal = true;
    }
};
