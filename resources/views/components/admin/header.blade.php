@role('admin')
<flux:header class="lg:hidden">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

    <flux:spacer />

    <flux:dropdown position="bottom" align="end">
        <flux:profile
            avatar="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random"
            name="{{ auth()->user()->name }}"
        />

        <flux:menu>
            <flux:menu.item wire:navigate icon="user-circle" href="{{ route('admin.profile') }}">
                Profile
            </flux:menu.item>

            <flux:menu.separator />

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <flux:menu.item type="submit" icon="arrow-right-start-on-rectangle">
                    Logout
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>
</flux:header>
@endrole
