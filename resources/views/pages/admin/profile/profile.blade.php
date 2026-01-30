<div class="space-y-6">
    <flux:heading size="xl">Profile</flux:heading>

    {{-- Profile Information --}}
    <flux:card class="dark:bg-zinc-950">
        <div class="space-y-6">
            <flux:heading size="lg">Profile Information</flux:heading>
            <flux:text class="text-zinc-600 dark:text-zinc-400">Update your account's profile information and email address.</flux:text>

            <form wire:submit="updateProfile" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:field>
                        <flux:label>Name</flux:label>
                        <flux:input wire:model="name" placeholder="Your name" />
                        <flux:error name="name" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Email</flux:label>
                        <flux:input type="email" wire:model="email" placeholder="your@email.com" />
                        <flux:error name="email" />
                    </flux:field>
                </div>

                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="w-full sm:w-auto">
                        Save Profile
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:card>

    {{-- Update Password --}}
    <flux:card class="dark:bg-zinc-950">
        <div class="space-y-6">
            <flux:heading size="lg">Update Password</flux:heading>
            <flux:text class="text-zinc-600 dark:text-zinc-400">Ensure your account is using a long, random password to stay secure.</flux:text>

            <form wire:submit="updatePassword" class="space-y-6">
                <div class="grid grid-cols-1 gap-6">
                    <flux:field>
                        <flux:label>Current Password</flux:label>
                        <flux:input type="password" wire:model="currentPassword" placeholder="Current password" />
                        <flux:error name="currentPassword" />
                    </flux:field>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <flux:field>
                            <flux:label>New Password</flux:label>
                            <flux:input type="password" wire:model="newPassword" placeholder="New password" />
                            <flux:error name="newPassword" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Confirm Password</flux:label>
                            <flux:input type="password" wire:model="newPasswordConfirmation" placeholder="Confirm new password" />
                            <flux:error name="newPasswordConfirmation" />
                        </flux:field>
                    </div>
                </div>

                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="w-full sm:w-auto">
                        Update Password
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:card>
</div>
