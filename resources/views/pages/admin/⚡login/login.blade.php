<div class="min-h-screen flex items-center justify-center bg-zinc-50 dark:bg-zinc-900 px-4">
    <form wire:submit="login" class="w-full max-w-md">
        @csrf
        <flux:card class="space-y-8">
            {{-- Header --}}
            <div class="text-center">
                <div class="mx-auto w-16 h-16 bg-zinc-900 dark:bg-white rounded-2xl flex items-center justify-center mb-6">
                    <flux:icon name="lock-closed" variant="solid" class="size-8 text-white dark:text-zinc-900" />
                </div>
                <flux:heading size="xl">Admin Login</flux:heading>
                <flux:text class="mt-2">Sign in to access the admin panel.</flux:text>
            </div>

            <flux:separator />

            {{-- Form Fields --}}
            <div class="space-y-6">
                <flux:input
                    wire:model.defer="email"
                    label="Email address"
                    type="email"
                    placeholder="admin@example.com"
                    icon="envelope"
                    data-test="email-input"
                />

                <flux:input
                    wire:model.defer="password"
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
</div>
