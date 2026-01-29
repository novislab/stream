<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts::admin')] #[Title('Admin Login')] class extends Component
{
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    public function login(): void
    {
        if ($this->email === '' || $this->email === '0' || ($this->password === '' || $this->password === '0')) {
            $this->js("Flux.toast({ text: 'Email and password are required.', variant: 'danger' })");

            return;
        }

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->js("Flux.toast({ text: 'Invalid credentials.', variant: 'danger' })");

            return;
        }

        $user = Auth::user();

        if (! $user->hasRole('admin')) {
            Auth::logout();
            $this->js("Flux.toast({ text: 'Invalid credentials.', variant: 'danger' })");

            return;
        }

        session()->regenerate();

        $this->redirect(route('admin.dashboard'), navigate: true);
    }
};
