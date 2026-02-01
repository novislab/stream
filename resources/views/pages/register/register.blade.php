<div class="flex min-h-screen items-center justify-center bg-gradient-to-br from-[#0a1f1f] via-[#0d2e2e] to-[#0a2525] px-4 py-8">
    {{-- Background effects --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -top-20 -right-20 h-60 w-60 rounded-full bg-teal-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 -left-20 h-60 w-60 rounded-full bg-emerald-500/10 blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-md">
        {{-- Logo --}}
        <div class="mb-6 flex justify-center">
            <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2">
                <svg class="h-8 w-8 text-teal-400" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M3 7h18v2H3V7zm0 4h18v2H3v-2zm0 4h12v2H3v-2z"/>
                </svg>
                <span class="text-2xl font-bold text-white">Stream</span>
            </a>
        </div>

        {{-- Form Card --}}
        <div class="rounded-2xl border border-teal-800/50 bg-[#0a1f1f]/80 p-6 shadow-2xl backdrop-blur-sm md:p-8">
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
                        class="w-full rounded-lg border border-teal-800/50 bg-[#081818] px-4 py-3 text-sm text-white placeholder-gray-500 transition-colors focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500"
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
                        class="w-full rounded-lg border border-teal-800/50 bg-[#081818] px-4 py-3 text-sm text-white placeholder-gray-500 transition-colors focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500"
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
                        class="w-full rounded-lg border border-teal-800/50 bg-[#081818] px-4 py-3 text-sm text-white placeholder-gray-500 transition-colors focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500"
                    >
                </div>

                {{-- Referral Code --}}
                <div>
                    <label for="referralCode" class="mb-1.5 block text-sm font-medium text-gray-300">Referral Code <span class="text-gray-500">(Optional)</span></label>
                    <input
                        type="text"
                        id="referralCode"
                        wire:model="referralCode"
                        placeholder="Enter referral code"
                        class="w-full rounded-lg border border-teal-800/50 bg-[#081818] px-4 py-3 text-sm text-white placeholder-gray-500 transition-colors focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500"
                    >
                </div>

                {{-- Activation Code --}}
                <div>
                    <div class="mb-1.5 flex items-center justify-between">
                        <label for="activationCode" class="text-sm font-medium text-gray-300">Activation Code</label>
                        <a href="{{ route('payment') }}" wire:navigate class="text-xs text-teal-400 hover:text-teal-300 hover:underline">Don't have a code? Get one here</a>
                    </div>
                    <input
                        type="text"
                        id="activationCode"
                        wire:model="activationCode"
                        placeholder="Enter your activation code"
                        class="w-full rounded-lg border border-teal-800/50 bg-[#081818] px-4 py-3 text-sm text-white placeholder-gray-500 transition-colors focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500"
                    >
                    <p class="mt-1.5 text-xs text-gray-500">Activation code is required to complete registration</p>
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-gray-300">Password</label>
                    <input
                        type="password"
                        id="password"
                        wire:model="password"
                        placeholder="Create a password"
                        class="w-full rounded-lg border border-teal-800/50 bg-[#081818] px-4 py-3 text-sm text-white placeholder-gray-500 transition-colors focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500"
                    >
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="passwordConfirmation" class="mb-1.5 block text-sm font-medium text-gray-300">Confirm Password</label>
                    <input
                        type="password"
                        id="passwordConfirmation"
                        wire:model="passwordConfirmation"
                        placeholder="Confirm your password"
                        class="w-full rounded-lg border border-teal-800/50 bg-[#081818] px-4 py-3 text-sm text-white placeholder-gray-500 transition-colors focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500"
                    >
                </div>

                {{-- Terms --}}
                <div class="flex items-start gap-3">
                    <input
                        type="checkbox"
                        id="agreeTerms"
                        wire:model="agreeTerms"
                        class="mt-1 h-4 w-4 rounded border-teal-800 bg-[#081818] text-teal-500 focus:ring-teal-500"
                    >
                    <label for="agreeTerms" class="text-sm text-gray-400">
                        I agree to the <a href="#" class="text-teal-400 hover:underline">Terms of Service</a> and <a href="#" class="text-teal-400 hover:underline">Privacy Policy</a>
                    </label>
                </div>

                {{-- Submit Button --}}
                <button
                    type="submit"
                    class="w-full rounded-lg bg-linear-to-r from-teal-500 to-emerald-500 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-teal-500/25 transition-all hover:scale-[1.02] hover:shadow-xl hover:shadow-teal-500/30 active:scale-[0.98]"
                >
                    Sign Up Now
                </button>
            </form>

            {{-- Divider --}}
            <div class="my-6 flex items-center gap-4">
                <div class="h-px flex-1 bg-teal-800/50"></div>
                <span class="text-sm text-gray-500">or</span>
                <div class="h-px flex-1 bg-teal-800/50"></div>
            </div>

            {{-- Login Link --}}
            <p class="text-center text-sm text-gray-400">
                Already have an account?
                <a href="#" class="font-medium text-teal-400 hover:underline">Sign In</a>
            </p>
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
            <div class="relative w-full max-w-sm rounded-2xl border border-red-500/30 bg-[#0a1f1f] p-6 shadow-2xl">
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
                    <a href="{{ route('payment') }}" wire:navigate class="block w-full rounded-lg bg-linear-to-r from-teal-500 to-emerald-500 px-4 py-3 text-center text-sm font-semibold text-white shadow-lg shadow-teal-500/25 transition-all hover:scale-[1.02]">
                        Get Activation Code
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
