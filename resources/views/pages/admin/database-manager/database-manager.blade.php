<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="xl">Database Manager</flux:heading>
            <flux:text class="text-zinc-500">Manage SQL migrations and backups</flux:text>
        </div>
        <div class="flex gap-2">
            <flux:button wire:click="createBackup" wire:loading.attr="disabled" icon="arrow-down-tray" variant="ghost">
                <span wire:loading.remove wire:target="createBackup">Create Backup</span>
                <span wire:loading wire:target="createBackup">Creating...</span>
            </flux:button>
            <flux:button wire:click="importLatest" wire:loading.attr="disabled" wire:confirm="This will replace all database tables. Continue?" icon="arrow-up-tray" variant="primary">
                <span wire:loading.remove wire:target="importLatest">Import Latest</span>
                <span wire:loading wire:target="importLatest">Importing...</span>
            </flux:button>
        </div>
    </div>

    {{-- Message --}}
    @if($message)
        <flux:callout :variant="$messageType === 'error' ? 'danger' : 'success'" icon="{{ $messageType === 'error' ? 'x-circle' : 'check-circle' }}">
            {{ $message }}
        </flux:callout>
    @endif

    {{-- Migration Files --}}
    <flux:card class="p-5! dark:bg-zinc-950">
        <flux:heading class="mb-4">Migration SQL Files</flux:heading>
        @if(count($this->migrations) > 0)
            <div class="space-y-2">
                @foreach($this->migrations as $file)
                    <div class="flex items-center justify-between p-3 rounded-lg bg-zinc-100 dark:bg-zinc-800/50">
                        <div class="flex items-center gap-3">
                            <div class="rounded-lg bg-indigo-500/20 p-2">
                                <flux:icon name="document-text" class="size-5 text-indigo-500" />
                            </div>
                            <div>
                                <p class="text-sm font-medium">{{ $file['name'] }}</p>
                                <p class="text-xs text-zinc-500">{{ $file['size'] }} • {{ $file['date'] }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <flux:button size="sm" variant="ghost" wire:click="importFile('{{ $file['path'] }}')" wire:confirm="Import this file? Current data will be backed up first." wire:loading.attr="disabled">
                                Import
                            </flux:button>
                            <flux:button size="sm" variant="ghost" icon="trash" wire:click="deleteFile('{{ $file['name'] }}')" wire:confirm="Delete this file?" />
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-zinc-500">
                <flux:icon name="document" class="size-10 mx-auto mb-2 opacity-50" />
                <p>No migration files yet</p>
                <p class="text-xs mt-1">SQL files will appear here after deployment</p>
            </div>
        @endif
    </flux:card>

    {{-- Backup Files --}}
    <flux:card class="p-5! dark:bg-zinc-950">
        <flux:heading class="mb-4">Backups (Last 5)</flux:heading>
        @if(count($this->backups) > 0)
            <div class="space-y-2">
                @foreach($this->backups as $file)
                    <div class="flex items-center justify-between p-3 rounded-lg bg-zinc-100 dark:bg-zinc-800/50">
                        <div class="flex items-center gap-3">
                            <div class="rounded-lg bg-green-500/20 p-2">
                                <flux:icon name="archive-box" class="size-5 text-green-500" />
                            </div>
                            <div>
                                <p class="text-sm font-medium">{{ $file['name'] }}</p>
                                <p class="text-xs text-zinc-500">{{ $file['size'] }} • {{ $file['date'] }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <flux:button size="sm" variant="ghost" wire:click="rollback('{{ $file['name'] }}')" wire:confirm="Rollback to this backup? Current data will be replaced." wire:loading.attr="disabled">
                                Rollback
                            </flux:button>
                            <flux:button size="sm" variant="ghost" icon="trash" wire:click="deleteFile('{{ $file['name'] }}')" wire:confirm="Delete this backup?" />
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-zinc-500">
                <flux:icon name="archive-box" class="size-10 mx-auto mb-2 opacity-50" />
                <p>No backups yet</p>
                <p class="text-xs mt-1">Backups are created automatically before imports</p>
            </div>
        @endif
    </flux:card>
</div>
