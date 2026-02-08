<div class="flex min-h-screen items-center justify-center bg-gradient-to-br from-[#0a1a1a] via-[#0d2525] to-[#0a1a1a] px-4 py-8">
    {{-- Background effects --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -top-20 -right-20 h-60 w-60 rounded-full bg-[#315150]/20 blur-3xl"></div>
        <div class="absolute bottom-0 -left-20 h-60 w-60 rounded-full bg-[#2a4040]/20 blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-md">
        {{-- Logo --}}
        <div class="mb-6 flex justify-center">
            <a href="{{ route('home') }}" wire:navigate>
                <img src="/images/logo.png" alt="Stream" class="h-12 w-auto">
            </a>
        </div>

        {{-- Form Card --}}
        <div class="rounded-2xl border border-[#315150]/50 bg-[#0a1a1a]/80 p-6 shadow-2xl backdrop-blur-sm md:p-8">
            <div class="mb-6 text-center">
                <h1 class="mb-2 text-2xl font-bold text-white">Create Account</h1>
                <p class="text-sm text-gray-400">Join Stream and start earning today</p>
            </div>

            <form wire:submit="register" class="space-y-4">
                {{-- Full Name --}}
                <div>
                    <label for="fullName" class="mb-1.5 block text-sm font-medium text-gray-300">Full Name</label>
                    <input
                        type="text"
                        id="fullName"
                        wire:model="fullName"
                        placeholder="Enter your full name"
                        autocomplete="off"
                        class="w-full rounded-lg border border-[#315150]/50 bg-[#081818] px-4 py-3 text-sm text-white placeholder-gray-500 transition-colors focus:border-[#315150] focus:outline-none focus:ring-1 focus:ring-[#315150]"
                    >
                </div>

                {{-- Username --}}
                <div>
                    <label for="username" class="mb-1.5 block text-sm font-medium text-gray-300">Username</label>
                    <input
                        type="text"
                        id="username"
                        wire:model="username"
                        placeholder="Choose a username"
                        autocomplete="off"
                        class="w-full rounded-lg border border-[#315150]/50 bg-[#081818] px-4 py-3 text-sm text-white placeholder-gray-500 transition-colors focus:border-[#315150] focus:outline-none focus:ring-1 focus:ring-[#315150]"
                    >
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-gray-300">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        wire:model="email"
                        placeholder="Enter your email"
                        autocomplete="off"
                        class="w-full rounded-lg border border-[#315150]/50 bg-[#081818] px-4 py-3 text-sm text-white placeholder-gray-500 transition-colors focus:border-[#315150] focus:outline-none focus:ring-1 focus:ring-[#315150]"
                    >
                </div>

                {{-- Phone --}}
                <div>
                    <label for="phone" class="mb-1.5 block text-sm font-medium text-gray-300">Phone Number</label>
                    <input
                        type="tel"
                        id="phone"
                        wire:model="phone"
                        placeholder="Enter your phone number"
                        autocomplete="off"
                        class="w-full rounded-lg border border-[#315150]/50 bg-[#081818] px-4 py-3 text-sm text-white placeholder-gray-500 transition-colors focus:border-[#315150] focus:outline-none focus:ring-1 focus:ring-[#315150]"
                    >
                </div>

                {{-- Activation Code --}}
                <div>
                    <div class="mb-1.5 flex items-center justify-between">
                        <label for="activationCode" class="text-sm font-medium text-gray-300">Activation Code</label>
                        <a href="{{ route('payment') }}" wire:navigate class="text-xs text-[#3d6363] hover:text-[#315150] hover:underline">Get code here</a>
                    </div>
                    <input
                        type="text"
                        id="activationCode"
                        wire:model="activationCode"
                        placeholder="Enter your activation code"
                        autocomplete="off"
                        class="w-full rounded-lg border border-[#315150]/50 bg-[#081818] px-4 py-3 text-sm text-white placeholder-gray-500 transition-colors focus:border-[#315150] focus:outline-none focus:ring-1 focus:ring-[#315150]"
                    >
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-gray-300">Password</label>
                    <input
                        type="password"
                        id="password"
                        wire:model="password"
                        placeholder="Create a password"
                        autocomplete="off"
                        class="w-full rounded-lg border border-[#315150]/50 bg-[#081818] px-4 py-3 text-sm text-white placeholder-gray-500 transition-colors focus:border-[#315150] focus:outline-none focus:ring-1 focus:ring-[#315150]"
                    >
                </div>

                {{-- Submit Button --}}
                <button
                    type="submit"
                    class="w-full rounded-lg bg-linear-to-r from-[#315150] to-[#3d6363] px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-[#315150]/25 transition-all hover:scale-[1.02] hover:shadow-xl hover:shadow-[#315150]/30 active:scale-[0.98]"
                >
                    Sign Up Now
                </button>
            </form>


        </div>

        {{-- Bottom Text --}}
        <p class="mt-6 text-center text-xs text-gray-500">
            &copy; {{ date('Y') }} Stream Africa. All rights reserved.
        </p>
    </div>

    {{-- Invalid Activation Code Modal --}}
    @if ($showInvalidCodeModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data x-init="$el.querySelector('input')?.focus()">
            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" wire:click="closeModal"></div>

            {{-- Modal --}}
            <div class="relative w-full max-w-sm rounded-2xl border border-red-500/30 bg-[#0a1a1a] p-6 shadow-2xl">
                {{-- Close button --}}
                <button wire:click="closeModal" class="absolute right-4 top-4 text-gray-400 hover:text-white">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                {{-- Icon --}}
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-500/20">
                    <svg class="h-8 w-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>

                {{-- Content --}}
                <div class="text-center">
                    <h3 class="mb-2 text-xl font-bold text-white">Invalid Activation Code</h3>
                    <p class="mb-6 text-sm text-gray-400">
                        The activation code you entered is invalid or has already been used. Please get a valid activation code to continue.
                    </p>

                    {{-- Button --}}
                    <a href="{{ route('payment') }}" wire:navigate class="block w-full rounded-lg bg-linear-to-r from-[#315150] to-[#3d6363] px-4 py-3 text-center text-sm font-semibold text-white shadow-lg shadow-[#315150]/25 transition-all hover:scale-[1.02]">
                        Get Activation Code
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>