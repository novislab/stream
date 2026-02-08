<div class="min-h-screen flex justify-center">
    @if ($this->isSetup)
        {{-- Setup / Create First Admin --}}
        <form wire:submit="register" class="w-full max-w-md">
            @csrf
            <flux:card class="space-y-8">
                {{-- Header --}}
                <div class="text-center">
                    <div class="mx-auto w-16 h-16 flex items-center justify-center mb-6">
                        <img src="/images/logo.png" alt="Stream" class="w-16 h-auto">
                    </div>
                    <flux:heading size="xl">Welcome to Stream</flux:heading>
                    <flux:text class="mt-2">Create your admin account to get started.</flux:text>
                </div>

                <flux:separator />

                {{-- Form Fields --}}
                <div class="space-y-6">
                    <flux:input
                        wire:model="name"
                        label="Full Name"
                        type="text"
                        placeholder="John Doe"
                        icon="user"
                    />
                    <flux:error name="name" />

                    <flux:input
                        wire:model="email"
                        label="Email address"
                        type="email"
                        placeholder="admin@example.com"
                        icon="envelope"
                    />
                    <flux:error name="email" />

                    <flux:input
                        wire:model="password"
                        label="Password"
                        type="password"
                        placeholder="Create a password"
                        icon="key"
                        viewable
                    />
                    <flux:error name="password" />

                    <flux:input
                        wire:model="passwordConfirmation"
                        label="Confirm Password"
                        type="password"
                        placeholder="Confirm your password"
                        icon="key"
                        viewable
                    />
                    <flux:error name="passwordConfirmation" />
                </div>

                {{-- Submit Button --}}
                <flux:button type="submit" variant="primary" class="w-full">
                    Create Admin Account
                </flux:button>
            </flux:card>
        </form>
    @else
        {{-- Login Form --}}
        <form wire:submit="login" class="w-full max-w-md">
            @csrf
            <flux:card class="space-y-8">
                {{-- Header --}}
                <div class="text-center">
                    <div class="mx-auto w-16 h-16 flex items-center justify-center mb-6">
                        <img src="/images/logo.png" alt="Stream" class="w-16 h-auto">
                    </div>
                    <flux:heading size="xl">Stream Admin</flux:heading>
                    <flux:text class="mt-2">Sign in to access the admin panel.</flux:text>
                </div>

                <flux:separator />

                {{-- Form Fields --}}
                <div class="space-y-6">
                    <flux:input
                        wire:model="email"
                        label="Email address"
                        type="email"
                        placeholder="admin@example.com"
                        icon="envelope"
                        data-test="email-input"
                    />

                    <flux:input
                        wire:model="password"
                        label="Password"
                        type="password"
                        placeholder="Enter your password"
                        icon="key"
                        viewable
                        data-test="password-input"
                    />

                    <div class="flex items-center justify-between">
                        <flux:checkbox wire:model="remember" label="Remember me" data-test="remember-checkbox" />
                    </div>
                </div>

                {{-- Submit Button --}}
                <flux:button type="submit" variant="primary" class="w-full" data-test="login-button">
                    Sign in
                </flux:button>
            </flux:card>
        </form>
    @endif
</div>
