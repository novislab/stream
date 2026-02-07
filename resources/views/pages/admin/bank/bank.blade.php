<div class="space-y-6">
    <div class="flex justify-between items-center">
        <flux:heading size="xl">Bank Management</flux:heading>
        <flux:button variant="primary" icon="plus" wire:click="showAddBankForm">Add Bank</flux:button>
    </div>

    {{-- Add New Bank Form --}}
    @if($showAddForm)
        <flux:card class="dark:bg-zinc-950 border-2 border-blue-500/30">
            <div class="space-y-6">
                <flux:heading size="lg">Add New Bank</flux:heading>

                <form wire:submit="saveNewBank" class="space-y-6">
                    <div class="grid grid-cols-1 gap-6">
                        <flux:field>
                            <flux:label>Bank Name</flux:label>
                            <flux:input wire:model="new_bank_name" placeholder="Access Bank" />
                            <flux:error name="new_bank_name" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Account Name</flux:label>
                            <flux:input wire:model="new_account_name" placeholder="Stream Africa Limited" />
                            <flux:error name="new_account_name" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Account Number</flux:label>
                            <flux:input wire:model="new_account_number" placeholder="0691234567" />
                            <flux:error name="new_account_number" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Status</flux:label>
                            <flux:switch wire:model="new_is_active" label="Active" />
                            <flux:error name="new_is_active" />
                        </flux:field>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end gap-3">
                        <flux:button type="button" variant="ghost" wire:click="hideAddBankForm">Cancel</flux:button>
                        <flux:button type="submit" variant="primary" icon="plus">Add Bank</flux:button>
                    </div>
                </form>
            </div>
        </flux:card>
    @endif

    {{-- Banks List --}}
    @if($banks->count() > 0)
        <div class="space-y-6">
            @foreach($banks as $bank)
                <flux:card class="dark:bg-zinc-950">
                    <form wire:submit="updateBank({{ $bank->id }})" class="space-y-6">
                        <div class="space-y-6">
                            <div class="flex justify-between items-center">
                                <flux:heading size="lg">{{ $bank->bank_name }}</flux:heading>
                                <div class="flex gap-2">
                                    <flux:button 
                                        type="button"
                                        variant="ghost" 
                                        size="sm" 
                                        wire:click="resetBank({{ $bank->id }})"
                                    >
                                        Reset
                                    </flux:button>
                                    <flux:button 
                                        type="button"
                                        variant="danger" 
                                        size="sm" 
                                        wire:click="deleteBank({{ $bank->id }})"
                                        wire:confirm="Are you sure you want to delete this bank?"
                                    >
                                        Delete
                                    </flux:button>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-6">
                                <flux:field>
                                    <flux:label>Bank Name</flux:label>
                                    <flux:input 
                                        wire:model="editingBanks.{{ $bank->id }}.bank_name" 
                                        placeholder="Access Bank" 
                                    />
                                    <flux:error name="editingBanks.{{ $bank->id }}.bank_name" />
                                </flux:field>

                                <flux:field>
                                    <flux:label>Account Name</flux:label>
                                    <flux:input 
                                        wire:model="editingBanks.{{ $bank->id }}.account_name" 
                                        placeholder="Stream Africa Limited" 
                                    />
                                    <flux:error name="editingBanks.{{ $bank->id }}.account_name" />
                                </flux:field>

                                <flux:field>
                                    <flux:label>Account Number</flux:label>
                                    <flux:input 
                                        wire:model="editingBanks.{{ $bank->id }}.account_number" 
                                        placeholder="0691234567" 
                                    />
                                    <flux:error name="editingBanks.{{ $bank->id }}.account_number" />
                                </flux:field>

                                <flux:field>
                                    <flux:label>Status</flux:label>
                                    <flux:switch 
                                        wire:model="editingBanks.{{ $bank->id }}.is_active" 
                                        label="Active" 
                                    />
                                    <flux:error name="editingBanks.{{ $bank->id }}.is_active" />
                                </flux:field>
                            </div>

                            <div class="flex flex-col sm:flex-row justify-end gap-3">
                                <flux:button type="submit" variant="primary" icon="check">Update Bank</flux:button>
                            </div>
                        </div>
                    </form>
                </flux:card>
            @endforeach
        </div>
    @else
        <flux:card class="dark:bg-zinc-950">
            <div class="text-center py-12">
                <flux:icon name="bank" class="w-16 h-16 mx-auto mb-4 text-zinc-400" />
                <flux:heading size="lg" class="mb-2">No Banks Added</flux:heading>
                <p class="text-zinc-600 dark:text-zinc-400 mb-6">Add your first bank account to get started.</p>
                <flux:button variant="primary" icon="plus" wire:click="showAddBankForm">Add First Bank</flux:button>
            </div>
        </flux:card>
    @endif
</div>