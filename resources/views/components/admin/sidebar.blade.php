@role('admin')
    <flux:sidebar sticky collapsible class="bg-zinc-50 dark:bg-zinc-950 border-r border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.header>
            <flux:brand href="{{ route('admin.dashboard') }}" wire:navigate name="{{ config('app.name') }}">
                <x-slot name="logo" class="size-6 rounded-full bg-cyan-500 text-white text-xs font-bold">
                    <flux:icon name="building-storefront" variant="micro" />
                </x-slot>
            </flux:brand>

            <flux:sidebar.collapse
                class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
        </flux:sidebar.header>

        <flux:sidebar.nav>
            <flux:sidebar.item wire:navigate icon="squares-2x2" href="{{ route('admin.dashboard') }}"
                :current="request()->routeIs('admin.dashboard')">Dashboard</flux:sidebar.item>
            <flux:sidebar.item wire:navigate icon="globe-alt" href="{{ route('admin.visitors') }}"
                :current="request()->routeIs('admin.visitors')">Visitors</flux:sidebar.item>
            <flux:sidebar.item wire:navigate icon="link" href="{{ route('admin.short-urls') }}"
                :current="request()->routeIs('admin.short-urls*')">Short URLs</flux:sidebar.item>
            <flux:sidebar.item wire:navigate icon="banknotes" href="{{ route('admin.bank') }}"
                :current="request()->routeIs('admin.bank*')">Bank</flux:sidebar.item>
            <flux:sidebar.item wire:navigate icon="credit-card" href="{{ route('admin.payments') }}"
                :current="request()->routeIs('admin.payments')">Payments</flux:sidebar.item>
            <flux:sidebar.item wire:navigate icon="cursor-arrow-rays" href="{{ route('admin.social-clicks') }}"
                :current="request()->routeIs('admin.social-clicks')">Social Clicks</flux:sidebar.item>
            <flux:sidebar.item wire:navigate icon="share" href="{{ route('admin.social-links') }}"
                :current="request()->routeIs('admin.social-links')">Social Links</flux:sidebar.item>
            <flux:sidebar.item wire:navigate icon="user-circle" href="{{ route('admin.profile') }}"
                :current="request()->routeIs('admin.profile')">Profile</flux:sidebar.item>
            <flux:sidebar.item wire:navigate icon="cog-6-tooth" href="{{ route('admin.settings') }}"
                :current="request()->routeIs('admin.settings')">Settings</flux:sidebar.item>
        </flux:sidebar.nav>

        <flux:sidebar.spacer />

        <flux:dropdown position="top" align="start" class="max-lg:hidden">
            <flux:sidebar.profile
                avatar="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random"
                name="{{ auth()->user()->name }}" />

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
    </flux:sidebar>
@endrole
