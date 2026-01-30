<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Role;

new #[Layout('layouts::admin')] #[Title('Admin Login')] class extends Component
{
    #[Validate('required_if:isSetup,true|string|max:255')]
    public string $name = '';

    #[Validate('required|email|max:255')]
    public string $email = '';

    #[Validate('required|string|min:8')]
    public string $password = '';

    #[Validate('required_if:isSetup,true|same:password')]
    public string $passwordConfirmation = '';

    public bool $remember = false;

    #[Computed]
    public function isSetup(): bool
    {
        return User::query()->count() === 0;
    }

    public function login(): void
    {
        if ($this->email === '' || $this->password === '') {
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

    public function register(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'passwordConfirmation' => ['required', 'same:password'],
        ]);

        Role::findOrCreate('admin');

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $user->assignRole('admin');

        Auth::login($user);
        session()->regenerate();

        $this->redirect(route('admin.dashboard'), navigate: true);
    }
};
