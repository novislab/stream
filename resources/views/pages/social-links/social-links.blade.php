
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <flux:heading size="xl">Social Links Management</flux:heading>
        <flux:button variant="primary" icon="plus" wire:click="showAddSocialLinkForm">Add Social Link</flux:button>
    </div>

    {{-- Add New Social Link Form --}}
    @if($showAddForm)
        <flux:card class="dark:bg-zinc-950 border-2 border-blue-500/30">
            <div class="space-y-6">
                <flux:heading size="lg">Add New Social Link</flux:heading>

                <form wire:submit="saveNewSocialLink" class="space-y-6">
                    <div class="grid grid-cols-1 gap-6">
                        <flux:field>
                            <flux:label>Platform</flux:label>
                            <flux:input wire:model="new_platform" placeholder="Facebook" />
                            <flux:error name="new_platform" />
                        </flux:field>

                        <flux:field>
                            <flux:label>URL</flux:label>
                            <flux:input wire:model="new_url" placeholder="https://facebook.com/yourpage" />
                            <flux:error name="new_url" />
                        </flux:field>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end gap-3">
                        <flux:button type="button" variant="ghost" wire:click="hideAddSocialLinkForm">Cancel</flux:button>
                        <flux:button type="submit" variant="primary" icon="plus">Add Social Link</flux:button>
                    </div>
                </form>
            </div>
        </flux:card>
    @endif

    {{-- Social Links List --}}
    @if($socialLinks->count() > 0)
        <div class="space-y-6">
            @foreach($socialLinks as $socialLink)
                <flux:card class="dark:bg-zinc-950">
                    <form wire:submit="updateSocialLink({{ $socialLink->id }})" class="space-y-6">
                        <div class="space-y-6">
                            <div class="flex justify-between items-center">
                                <flux:heading size="lg">{{ $socialLink->platform }}</flux:heading>
                                <div class="flex gap-2">
                                    <flux:button 
                                        type="button"
                                        variant="ghost" 
                                        size="sm" 
                                        wire:click="resetSocialLink({{ $socialLink->id }})"
                                    >
                                        Reset
                                    </flux:button>
                                    <flux:button 
                                        type="button"
                                        variant="danger" 
                                        size="sm" 
                                        wire:click="deleteSocialLink({{ $socialLink->id }})"
                                        wire:confirm="Are you sure you want to delete this social link?"
                                    >
                                        Delete
                                    </flux:button>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-6">
                                <flux:field>
                                    <flux:label>Platform</flux:label>
                                    <flux:input 
                                        wire:model="editingSocialLinks.{{ $socialLink->id }}.platform" 
                                        placeholder="Facebook" 
                                    />
                                    <flux:error name="editingSocialLinks.{{ $socialLink->id }}.platform" />
                                </flux:field>

                                <flux:field>
                                    <flux:label>URL</flux:label>
                                    <flux:input 
                                        wire:model="editingSocialLinks.{{ $socialLink->id }}.url" 
                                        placeholder="https://facebook.com/yourpage" 
                                    />
                                    <flux:error name="editingSocialLinks.{{ $socialLink->id }}.url" />
                                </flux:field>
                            </div>

                            <div class="flex flex-col sm:flex-row justify-end gap-3">
                                <flux:button type="submit" variant="primary" icon="check">Update Social Link</flux:button>
                            </div>
                        </div>
                    </form>
                </flux:card>
            @endforeach
        </div>
    @else
        <flux:card class="dark:bg-zinc-950">
            <div class="text-center py-12">
                <flux:icon name="share" class="w-16 h-16 mx-auto mb-4 text-zinc-400" />
                <flux:heading size="lg" class="mb-2">No Social Links Added</flux:heading>
                <p class="text-zinc-600 dark:text-zinc-400 mb-6">Add your first social media link to get started.</p>
                <flux:button variant="primary" icon="plus" wire:click="showAddSocialLinkForm">Add First Social Link</flux:button>
            </div>
        </flux:card>
    @endif
</div>