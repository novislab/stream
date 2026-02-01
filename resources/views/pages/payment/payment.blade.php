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

        {{-- Payment Card --}}
        <div class="rounded-2xl border border-teal-800/50 bg-[#0a1f1f]/80 p-6 shadow-2xl backdrop-blur-sm md:p-8">
            <div class="mb-6 text-center">
                <h1 class="mb-2 text-2xl font-bold text-white">Get Activation Code</h1>
                <p class="text-sm text-gray-400">Complete payment to receive your activation code</p>
            </div>

            {{-- Price Card --}}
            <div class="mb-6 rounded-xl border border-teal-500/30 bg-teal-500/10 p-4 text-center">
                <p class="mb-1 text-sm text-gray-400">Onboarding Fee</p>
                <p class="text-4xl font-bold text-white">₦12,000</p>
                <p class="mt-2 text-xs text-teal-400">One-time payment • Lifetime access</p>
            </div>

            {{-- What you get --}}
            <div class="mb-6">
                <h3 class="mb-3 text-sm font-semibold text-gray-300">What you'll get:</h3>
                <ul class="space-y-2">
                    <li class="flex items-center gap-2 text-sm text-gray-400">
                        <svg class="h-4 w-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Instant Activation Code
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-400">
                        <svg class="h-4 w-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        100% Cashback (₦12,000)
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-400">
                        <svg class="h-4 w-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Access to all collaboration types
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-400">
                        <svg class="h-4 w-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Stream SkillUp courses
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-400">
                        <svg class="h-4 w-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Stream Partner Bonus (₦10,200)
                    </li>
                </ul>
            </div>

            {{-- Payment Methods --}}
            <div class="mb-6">
                <h3 class="mb-3 text-sm font-semibold text-gray-300">Select Payment Method:</h3>
                <div class="space-y-3">
                    <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-teal-800/50 bg-[#081818] p-4 transition-colors hover:border-teal-500/50">
                        <input type="radio" name="paymentMethod" value="bank" class="h-4 w-4 border-teal-800 bg-[#081818] text-teal-500 focus:ring-teal-500" checked>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white">Bank Transfer</p>
                            <p class="text-xs text-gray-500">Transfer to our bank account</p>
                        </div>
                    </label>
                    <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-teal-800/50 bg-[#081818] p-4 transition-colors hover:border-teal-500/50">
                        <input type="radio" name="paymentMethod" value="card" class="h-4 w-4 border-teal-800 bg-[#081818] text-teal-500 focus:ring-teal-500">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white">Card Payment</p>
                            <p class="text-xs text-gray-500">Pay with debit/credit card</p>
                        </div>
                    </label>
                    <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-teal-800/50 bg-[#081818] p-4 transition-colors hover:border-teal-500/50">
                        <input type="radio" name="paymentMethod" value="ussd" class="h-4 w-4 border-teal-800 bg-[#081818] text-teal-500 focus:ring-teal-500">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white">USSD</p>
                            <p class="text-xs text-gray-500">Pay using USSD code</p>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Pay Button --}}
            <button
                type="button"
                wire:click="processPayment"
                class="w-full rounded-lg bg-linear-to-r from-teal-500 to-emerald-500 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-teal-500/25 transition-all hover:scale-[1.02] hover:shadow-xl hover:shadow-teal-500/30 active:scale-[0.98]"
            >
                Pay ₦12,000
            </button>

            {{-- Security Note --}}
            <div class="mt-4 flex items-center justify-center gap-2 text-xs text-gray-500">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Secure payment powered by Paystack
            </div>
        </div>

        {{-- Back to Register --}}
        <p class="mt-6 text-center text-sm text-gray-400">
            Already have an activation code?
            <a href="{{ route('register') }}" wire:navigate class="font-medium text-teal-400 hover:underline">Register here</a>
        </p>

        {{-- Bottom Text --}}
        <p class="mt-4 text-center text-xs text-gray-500">
            &copy; {{ date('Y') }} Stream Africa. All rights reserved.
        </p>
    </div>

    {{-- Payment Processing Modal --}}
    @if ($showProcessingModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>

            {{-- Modal --}}
            <div class="relative w-full max-w-sm rounded-2xl border border-teal-500/30 bg-[#0a1f1f] p-6 shadow-2xl">
                {{-- Loading Spinner --}}
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center">
                    <svg class="h-12 w-12 animate-spin text-teal-500" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>

                {{-- Content --}}
                <div class="text-center">
                    <h3 class="mb-2 text-xl font-bold text-white">Processing Payment</h3>
                    <p class="text-sm text-gray-400">
                        Please wait while we process your payment. Do not close this window.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
