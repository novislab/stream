<div class="space-y-6">
    <flux:heading size="xl">Settings</flux:heading>

    <form wire:submit="save" class="space-y-6">
        {{-- General Settings --}}
        <flux:card class="dark:bg-zinc-950">
            <div class="space-y-6">
                <flux:heading size="lg">General Settings</flux:heading>

                <div class="grid grid-cols-1 gap-6">
                    <flux:field>
                        <flux:label>Application Name</flux:label>
                        <flux:description>The name of your application displayed across the site.</flux:description>
                        <flux:input
                            wire:model="appName"
                            placeholder="My Application"
                        />
                        <flux:error name="appName" />
                    </flux:field>
                </div>
            </div>
        </flux:card>

        {{-- Social Links --}}
        <flux:card class="dark:bg-zinc-950">
            <div class="space-y-6">
                <flux:heading size="lg">Social Links</flux:heading>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:field>
                        <flux:label>WhatsApp Link</flux:label>
                        <flux:description>Your WhatsApp contact link (e.g., https://wa.me/1234567890)</flux:description>
                        <flux:input
                            type="url"
                            wire:model="whatsappLink"
                            placeholder="https://wa.me/1234567890"
                        />
                        <flux:error name="whatsappLink" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Telegram Link</flux:label>
                        <flux:description>Your Telegram contact link (e.g., https://t.me/username)</flux:description>
                        <flux:input
                            type="url"
                            wire:model="telegramLink"
                            placeholder="https://t.me/username"
                        />
                        <flux:error name="telegramLink" />
                    </flux:field>
                </div>
            </div>
        </flux:card>

        {{-- Save Button --}}
        <div class="flex flex-col sm:flex-row justify-end gap-3">
            <flux:button type="submit" variant="primary" icon="check" class="w-full sm:w-auto">
                Save Settings
            </flux:button>
        </div>
    </form>
</div>
