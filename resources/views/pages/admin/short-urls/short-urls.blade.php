<div class="space-y-6">
    <flux:heading size="xl">Short URL Manager</flux:heading>

    {{-- Create Short URL Form --}}
    <flux:card class="dark:bg-zinc-950">
        <form wire:submit="createShortUrl" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:field>
                    <flux:label>Original URL</flux:label>
                    <flux:input
                        type="url"
                        wire:model="originalUrl"
                        placeholder="https://example.com/very-long-url"
                    />
                    <flux:error name="originalUrl" />
                </flux:field>

                <flux:field>
                    <flux:label>Title (optional)</flux:label>
                    <flux:input
                        wire:model="title"
                        placeholder="My awesome link"
                    />
                    <flux:error name="title" />
                </flux:field>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <flux:field>
                    <flux:label>Expires At (optional)</flux:label>
                    <flux:input
                        type="datetime-local"
                        wire:model="expiresAt"
                    />
                    <flux:error name="expiresAt" />
                </flux:field>

                <flux:field>
                    <flux:label>Max Views (optional)</flux:label>
                    <flux:input
                        type="number"
                        wire:model="maxViews"
                        placeholder="Unlimited"
                        min="1"
                    />
                    <flux:error name="maxViews" />
                </flux:field>

                <div class="flex items-end">
                    <flux:button type="submit" variant="primary" icon="plus">
                        Create Short URL
                    </flux:button>
                </div>
            </div>
        </form>
    </flux:card>

    {{-- Short URLs Table --}}
    <flux:card class="dark:bg-zinc-950 overflow-x-auto">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Title / Code</flux:table.column>
                <flux:table.column class="hidden md:table-cell">Original URL</flux:table.column>
                <flux:table.column>Clicks</flux:table.column>
                <flux:table.column class="hidden sm:table-cell">Status</flux:table.column>
                <flux:table.column class="hidden lg:table-cell">Created</flux:table.column>
                <flux:table.column>Actions</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($this->shortUrls as $shortUrl)
                    <flux:table.row wire:key="short-url-{{ $shortUrl->id }}">
                        <flux:table.cell>
                            <div>
                                @if ($shortUrl->title)
                                    <p class="font-medium">{{ $shortUrl->title }}</p>
                                @endif
                                <button
                                    type="button"
                                    wire:click="copyToClipboard('{{ $shortUrl->short_url }}')"
                                    class="text-sm text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1"
                                >
                                    <flux:icon name="link" variant="mini" class="size-3" />
                                    {{ $shortUrl->code }}
                                </button>
                                {{-- Show status badge on mobile only --}}
                                <div class="sm:hidden mt-1">
                                    @if ($shortUrl->hasReachedMaxViews())
                                        <flux:badge color="red" size="sm">Max Reached</flux:badge>
                                    @elseif ($shortUrl->isExpired())
                                        <flux:badge color="amber" size="sm">Expired</flux:badge>
                                    @elseif ($shortUrl->is_active)
                                        <flux:badge color="green" size="sm">Active</flux:badge>
                                    @else
                                        <flux:badge color="zinc" size="sm">Inactive</flux:badge>
                                    @endif
                                </div>
                            </div>
                        </flux:table.cell>

                        <flux:table.cell class="hidden md:table-cell">
                            <span class="max-w-xs truncate block" title="{{ $shortUrl->original_url }}">
                                {{ Str::limit($shortUrl->original_url, 40) }}
                            </span>
                        </flux:table.cell>

                        <flux:table.cell>
                            <div class="flex items-center gap-1">
                                <flux:badge size="sm">{{ number_format($shortUrl->click_count) }}</flux:badge>
                                @if ($shortUrl->max_views)
                                    <span class="text-xs text-zinc-500">/ {{ number_format($shortUrl->max_views) }}</span>
                                @endif
                            </div>
                        </flux:table.cell>

                        <flux:table.cell class="hidden sm:table-cell">
                            @if ($shortUrl->hasReachedMaxViews())
                                <flux:badge color="red" size="sm">Max Reached</flux:badge>
                            @elseif ($shortUrl->isExpired())
                                <flux:badge color="amber" size="sm">Expired</flux:badge>
                            @elseif ($shortUrl->is_active)
                                <flux:badge color="green" size="sm">Active</flux:badge>
                            @else
                                <flux:badge color="zinc" size="sm">Inactive</flux:badge>
                            @endif
                        </flux:table.cell>

                        <flux:table.cell class="hidden lg:table-cell">
                            {{ $shortUrl->created_at->diffForHumans() }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <div class="flex items-center gap-1 sm:gap-2">
                                <flux:button
                                    size="xs"
                                    variant="ghost"
                                    icon="chart-bar"
                                    href="{{ route('admin.short-urls.show', $shortUrl) }}"
                                    wire:navigate
                                    class="hidden sm:inline-flex"
                                >
                                    Stats
                                </flux:button>
                                <flux:button
                                    size="xs"
                                    variant="ghost"
                                    icon="chart-bar"
                                    href="{{ route('admin.short-urls.show', $shortUrl) }}"
                                    wire:navigate
                                    class="sm:hidden"
                                />
                                <flux:button
                                    size="xs"
                                    variant="ghost"
                                    icon="pencil"
                                    wire:click="editShortUrl({{ $shortUrl->id }})"
                                    class="hidden sm:inline-flex"
                                >
                                    Edit
                                </flux:button>
                                <flux:button
                                    size="xs"
                                    variant="ghost"
                                    icon="pencil"
                                    wire:click="editShortUrl({{ $shortUrl->id }})"
                                    class="sm:hidden"
                                />
                                <flux:button
                                    size="xs"
                                    variant="ghost"
                                    icon="{{ $shortUrl->is_active ? 'eye-slash' : 'eye' }}"
                                    wire:click="toggleActive({{ $shortUrl->id }})"
                                    class="hidden sm:inline-flex"
                                >
                                    {{ $shortUrl->is_active ? 'Disable' : 'Enable' }}
                                </flux:button>
                                <flux:button
                                    size="xs"
                                    variant="ghost"
                                    icon="{{ $shortUrl->is_active ? 'eye-slash' : 'eye' }}"
                                    wire:click="toggleActive({{ $shortUrl->id }})"
                                    class="sm:hidden"
                                />
                                <flux:button
                                    size="xs"
                                    variant="danger"
                                    icon="trash"
                                    wire:click="deleteShortUrl({{ $shortUrl->id }})"
                                    wire:confirm="Are you sure you want to delete this short URL?"
                                    class="hidden sm:inline-flex"
                                >
                                    Delete
                                </flux:button>
                                <flux:button
                                    size="xs"
                                    variant="danger"
                                    icon="trash"
                                    wire:click="deleteShortUrl({{ $shortUrl->id }})"
                                    wire:confirm="Are you sure you want to delete this short URL?"
                                    class="sm:hidden"
                                />
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="6" class="text-center py-8">
                            <flux:icon name="link-slash" class="size-12 mx-auto mb-2 text-zinc-400" />
                            <p class="text-zinc-500">No short URLs yet. Create one above!</p>
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>

    {{-- Edit Modal --}}
    <flux:modal name="edit-modal" class="md:w-96">
        <div class="space-y-6">
            <flux:heading size="lg">Edit Short URL</flux:heading>

            <form wire:submit="updateShortUrl" class="space-y-4">
                <flux:field>
                    <flux:label>Original URL</flux:label>
                    <flux:input
                        type="url"
                        wire:model="originalUrl"
                        placeholder="https://example.com"
                    />
                    <flux:error name="originalUrl" />
                </flux:field>

                <flux:field>
                    <flux:label>Title (optional)</flux:label>
                    <flux:input
                        wire:model="title"
                        placeholder="My awesome link"
                    />
                    <flux:error name="title" />
                </flux:field>

                <flux:field>
                    <flux:label>Expires At (optional)</flux:label>
                    <flux:input
                        type="datetime-local"
                        wire:model="expiresAt"
                    />
                    <flux:error name="expiresAt" />
                </flux:field>

                <flux:field>
                    <flux:label>Max Views (optional)</flux:label>
                    <flux:input
                        type="number"
                        wire:model="maxViews"
                        placeholder="Unlimited"
                        min="1"
                    />
                    <flux:error name="maxViews" />
                </flux:field>

                <div class="flex justify-end gap-2">
                    <flux:button type="button" variant="ghost" wire:click="cancelEdit">
                        Cancel
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Save Changes
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>

@script
<script>
    $wire.on('copy-to-clipboard', ({ url }) => {
        navigator.clipboard.writeText(url);
    });
</script>
@endscript
