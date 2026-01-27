<div class="min-h-screen flex items-center justify-center">
    <form wire:submit="login">
        @csrf
        <flux:card class="min-w-96 space-y-6">
            <div>
                <flux:heading size="lg">Admin Login</flux:heading>
                <flux:text class="mt-2">Sign in to access the admin panel.</flux:text>
            </div>

            <div class="space-y-6">
                <flux:input wire:model.defer="email" label="Email" type="email" placeholder="Your email address" data-test="email-input" />

                <flux:input wire:model.defer="password" label="Password" type="password" placeholder="Your password" data-test="password-input" />

                <flux:checkbox wire:model="remember" label="Remember me" data-test="remember-checkbox" />
            </div>

            <div class="space-y-2">
                <flux:button type="submit" variant="primary" class="w-full" data-test="login-button">Log in</flux:button>
            </div>
        </flux:card>
    </form>
</div>
