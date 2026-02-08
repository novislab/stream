<div
    class="flex min-h-screen items-center justify-center bg-gradient-to-br from-[#0a1a1a] via-[#0d2525] to-[#0a1a1a] px-4 py-8">
    {{-- Background effects --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -top-20 -right-20 h-60 w-60 rounded-full bg-[#315150]/20 blur-3xl"></div>
        <div class="absolute bottom-0 -left-20 h-60 w-60 rounded-full bg-[#2a4040]/20 blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-md">


        {{-- Payment Card --}}
        <div class="rounded-2xl border border-[#315150]/50 bg-[#0a1a1a]/80 p-6 shadow-2xl backdrop-blur-sm md:p-8">
            <div class="mb-6 text-center">
                <h1 class="mb-2 text-2xl font-bold text-white">Get Activation Code</h1>
                <p class="text-sm text-gray-400">Complete payment to receive your activation code</p>
            </div>

            {{-- Price Card --}}
            <div class="mb-6 rounded-xl border border-[#315150]/30 bg-[#315150]/10 p-4 text-center">
                <p class="mb-1 text-sm text-gray-400">Onboarding Fee</p>
                <p class="text-4xl font-bold text-white">₦12,000</p>
                <p class="mt-2 text-xs text-[#3d6363]">One-time payment • Lifetime access</p>
            </div>

            {{-- Countdown Timer --}}
            <div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 p-4">
                <div class="text-center">
                    <h3 class="mb-2 text-sm font-semibold text-red-400">⏰ Limited Time Offer</h3>
                    <p class="mb-3 text-xs text-gray-400">Complete payment before time runs out!</p>
                    <div class="flex justify-center gap-2 text-2xl font-mono font-bold text-white">
                        <span id="countdown-minutes" class="bg-red-500/20 px-3 py-1 rounded">15</span>
                        <span class="text-red-400">:</span>
                        <span id="countdown-seconds" class="bg-red-500/20 px-3 py-1 rounded">00</span>
                    </div>
                    <p class="mt-2 text-xs text-gray-400">Minutes remaining</p>
                </div>
            </div>

            {{-- Bank Transfer Information --}}
            @if($banks->count() > 0)
                <div class="space-y-4">
                    <h3 class="mb-3 text-sm font-semibold text-gray-300">Select Bank for Transfer:</h3>
                    @foreach($banks as $index => $bank)
                        <div class="rounded-xl border border-[#315150]/30 bg-[#315150]/10 p-4 {{ $index === 0 ? 'ring-2 ring-[#315150]/50' : '' }}">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-[#3d6363]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <h4 class="text-white font-semibold">{{ $bank->bank_name }}</h4>
                                </div>
                                @if($index === 0)
                                    <span class="bg-[#315150]/20 text-[#3d6363] text-xs px-2 py-1 rounded-full">Recommended</span>
                                @endif
                            </div>
                            
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-400">Account Name:</span>
                                    <span class="text-white font-medium">{{ $bank->account_name }}</span>
                                </div>
                                
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-400">Account Number:</span>
                                    <div class="flex items-center gap-2">
                                        <span class="text-white font-mono text-sm">{{ $bank->account_number }}</span>
                                        <button
                                            onclick="copyToClipboard('{{ $bank->account_number }}', this)"
                                            class="p-1 rounded hover:bg-[#315150]/20 transition-colors"
                                            title="Copy account number"
                                        >
                                            <svg class="w-4 h-4 text-[#3d6363] copy-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-xs text-[#3d6363] hidden copied-text">Copied!</span>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-400">Amount:</span>
                                    <span class="text-white font-medium">₦12,000</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="rounded-xl border border-red-500/30 bg-red-500/10 p-4">
                    <div class="text-center">
                        <svg class="w-12 h-12 mx-auto mb-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <h3 class="mb-2 text-sm font-semibold text-red-400">No Active Banks Available</h3>
                        <p class="text-xs text-gray-400">Please contact support or check back later for payment options.</p>
                    </div>
                </div>
            @endif

            {{-- Payment Button --}}
            <button type="submit" class="w-full mt-6 inline-flex items-center justify-center gap-2 rounded-lg bg-linear-to-r from-[#315150] to-[#3d6363] px-6 py-3 text-center text-sm font-semibold text-white shadow-lg shadow-[#315150]/25 transition-all hover:scale-105" wire:click="recordPayment">
                I have made payment
            </button>

            {{-- Security Note --}}
            <div class="mt-4 flex items-center justify-center gap-2 text-xs text-gray-500">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Secure payment
            </div>
        </div>

        {{-- Countdown Timer Script --}}
        <script>
            let timeLeft = 15 * 60; // 15 minutes in seconds
            
            function updateCountdown() {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                
                document.getElementById('countdown-minutes').textContent = minutes.toString().padStart(2, '0');
                document.getElementById('countdown-seconds').textContent = seconds.toString().padStart(2, '0');
                
                if (timeLeft > 0) {
                    timeLeft--;
                } else {
                    // Timer expired - redirect or show message
                    window.location.reload();
                }
            }
            
            function copyToClipboard(text, button) {
                navigator.clipboard.writeText(text).then(function() {
                    const icon = button.querySelector('.copy-icon');
                    const copiedText = button.querySelector('.copied-text');
                    
                    // Hide icon and show "Copied!" text
                    icon.classList.add('hidden');
                    copiedText.classList.remove('hidden');
                    
                    // Reset after 2 seconds
                    setTimeout(function() {
                        icon.classList.remove('hidden');
                        copiedText.classList.add('hidden');
                    }, 2000);
                });
            }
            
            // Update immediately and then every second
            updateCountdown();
            setInterval(updateCountdown, 1000);
        </script>



        {{-- Bottom Text --}}

        

        <p class="mt-4 text-center text-xs text-gray-500">
            &copy; {{ date('Y') }} Stream Africa. All rights reserved.
        </p>
    </div>
</div>
