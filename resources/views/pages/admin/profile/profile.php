<?php

declare(strict_types=1);

use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

new #[Layout('layouts::admin')] #[Title('Profile')] class extends Component
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|email|max:255')]
    public string $email = '';

    public string $currentPassword = '';

    public string $newPassword = '';

    public string $newPasswordConfirmation = '';

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function updateProfile(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.Auth::id()],
        ]);

        Auth::user()->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        Flux::toast('Profile updated successfully.');
    }

    public function updatePassword(): void
    {
        $this->validate([
            'currentPassword' => ['required', 'current_password'],
            'newPassword' => ['required', Password::defaults(), 'confirmed:newPasswordConfirmation'],
            'newPasswordConfirmation' => ['required'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($this->newPassword),
        ]);

        $this->reset(['currentPassword', 'newPassword', 'newPasswordConfirmation']);

        Flux::toast('Password updated successfully.');
    }
};
