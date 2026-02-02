<div class="space-y-6">
    <flux:heading size="xl">Bank Details</flux:heading>

    <form wire:submit="save" class="space-y-6">
        <flux:card class="dark:bg-zinc-950">
            <div class="space-y-6">
                <flux:heading size="lg">Bank Account</flux:heading>

                <div class="grid grid-cols-1 gap-6">
                    <flux:field>
                        <flux:label>Bank Name</flux:label>
                        <flux:input wire:model="bank" placeholder="Example Bank" />
                        <flux:error name="bank" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Account Name</flux:label>
                        <flux:input wire:model="accountName" placeholder="John Doe" />
                        <flux:error name="accountName" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Account Number</flux:label>
                        <flux:input wire:model="accountNumber" placeholder="1234567890" />
                        <flux:error name="accountNumber" />
                    </flux:field>
                </div>
            </div>
        </flux:card>

        <div class="flex flex-col sm:flex-row justify-end gap-3">
            <flux:button type="submit" variant="primary" icon="check" class="w-full sm:w-auto">Save Bank</flux:button>
        </div>
    </form>
</div>
