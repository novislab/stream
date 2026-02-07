<div class="overflow-x-hidden">
    {{-- Hero Section --}}
    <section class="relative min-h-screen overflow-hidden bg-linear-to-br from-[#1a2f2f] via-[#2a3f3f] to-[#1a2f2f]">
        {{-- Background effects --}}
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-20 -right-20 h-40 w-40 rounded-full bg-[#315150]/20 blur-3xl md:-top-40 md:-right-40 md:h-96 md:w-96"></div>
            <div class="absolute top-1/3 -left-20 h-40 w-40 rounded-full bg-[#2a4040]/20 blur-3xl md:-left-40 md:h-80 md:w-80"></div>
        </div>

        {{-- Header --}}
        <header class="relative z-10 flex items-center justify-between px-4 py-4 md:px-12 md:py-6">
            <div class="flex items-center gap-2">
                <div class="flex h-8 w-8 items-center justify-center md:h-10 md:w-10">
                    <svg class="h-6 w-6 text-[#3d6363] md:h-8 md:w-8" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M3 7h18v2H3V7zm0 4h18v2H3v-2zm0 4h12v2H3v-2z"/>
                    </svg>
                </div>
                <span class="text-xl font-bold text-white md:text-2xl">Stream</span>
            </div>
            <div class="flex items-center gap-2 md:gap-4">
                <span class="hidden text-sm text-gray-400 lg:block">@officialstreamafrica</span>
                <a href="{{ route('register') }}" wire:navigate class="rounded-full bg-linear-to-r from-[#315150] to-[#3d6363] px-4 py-2 text-xs font-semibold text-white transition-all hover:scale-105 md:px-6 md:text-sm">
                    Join Now
                </a>
            </div>
        </header>

        <div class="relative mx-auto flex min-h-[85vh] max-w-7xl flex-col items-center justify-center px-4 py-8 md:px-6 lg:flex-row lg:justify-between lg:py-0">
            {{-- Left content --}}
            <div class="max-w-xl text-center lg:text-left">
                <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-[#315150]/30 bg-[#315150]/10 px-3 py-1.5 text-xs text-[#4a7575] md:mb-6 md:px-4 md:py-2 md:text-sm">
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#3d6363] opacity-75"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-[#315150]"></span>
                    </span>
                    Start Earning Today
                </div>

                <h1 class="mb-2 text-4xl font-bold text-white md:text-5xl lg:text-6xl">Skill Up</h1>
                <h2 class="mb-4 text-base font-semibold uppercase tracking-wide text-gray-300 md:mb-6 md:text-xl lg:text-2xl">
                    Growth Slows When Learning Stops.
                </h2>

                <p class="mb-6 text-sm leading-relaxed text-gray-400 md:mb-8 md:text-lg">
                    That's why STREAM brings you a carefully curated collection of high-income skills designed to sharpen your edge, expand your opportunities, and position you for real success.
                </p>

                <div class="flex flex-col gap-3 sm:flex-row sm:justify-center lg:justify-start">
                    <a href="{{ route('register') }}" wire:navigate class="group inline-flex items-center justify-center gap-2 rounded-xl bg-linear-to-r from-[#315150] to-[#3d6363] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-[#315150]/25 transition-all duration-300 hover:scale-105 md:px-8 md:py-4 md:text-lg">
                        Get Started
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1 md:h-5 md:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                    <a href="#earnings" class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#3d6363] bg-[#1a2f2f]/30 px-6 py-3 text-sm font-semibold text-white transition-all hover:border-[#315150] hover:bg-[#1a2f2f]/50 md:px-8 md:py-4 md:text-lg">
                        View Earnings
                    </a>
                </div>
            </div>

            {{-- Hero Image --}}
            <div class="mt-8 w-full max-w-xs px-4 sm:max-w-sm md:max-w-md lg:mt-0 lg:max-w-lg lg:px-0">
                <img src="/images/stream/hero.jpg" alt="Stream Skill Up" class="w-full rounded-2xl shadow-2xl shadow-[#315150]/20">
            </div>
        </div>
    </section>

    {{-- About Section --}}
    <section id="about" class="bg-[#081818] py-12 md:py-24">
        <div class="mx-auto max-w-7xl px-4 md:px-6">
            <div class="grid items-center gap-8 md:gap-12 lg:grid-cols-2">
                {{-- Image --}}
                <div class="order-2 lg:order-1">
                    <img src="/images/stream/about.jpg" alt="Who are we" class="w-full rounded-xl shadow-xl md:rounded-2xl">
                </div>

                {{-- Content --}}
                <div class="order-1 lg:order-2">
                    <span class="mb-3 inline-block rounded-full bg-[#315150]/10 px-3 py-1 text-xs font-medium text-[#3d6363] md:mb-4 md:px-4 md:text-sm">About Us</span>
                    <h2 class="mb-4 text-2xl font-bold text-white md:mb-6 md:text-4xl lg:text-5xl">Who Are We?</h2>
                    <p class="mb-4 text-sm leading-relaxed text-gray-400 md:mb-6 md:text-lg">
                        We are Stream, a digital movement redefining how Africans experience and earn from entertainment. Built on the belief that your time online should pay you back, Stream connects people, creativity, and opportunity in one continuous flow.
                    </p>
                    <p class="mb-4 text-sm text-gray-400 md:mb-6 md:text-base">
                        Through partnerships with artists, record labels, movie studios, and content distributors, Stream serves as a bridge between creators and the audience.
                    </p>
                    <p class="text-sm text-gray-400 md:text-base">
                        Stream transforms ordinary digital engagement into real value. Every time you collaborate, you're participating in a new digital economy where creativity and earnings flow together.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Collaboration Section --}}
    <section class="bg-linear-to-b from-[#081818] to-[#0a1f1f] py-12 md:py-24">
        <div class="mx-auto max-w-7xl px-4 md:px-6">
            <div class="mb-8 text-center md:mb-16">
                <span class="mb-3 inline-block rounded-full bg-[#315150]/10 px-3 py-1 text-xs font-medium text-[#3d6363] md:mb-4 md:px-4 md:text-sm">How You Earn</span>
                <h2 class="mb-3 text-2xl font-bold text-white md:mb-4 md:text-4xl lg:text-5xl">Collaboration Types</h2>
                <p class="mx-auto max-w-2xl text-sm text-gray-400 md:text-lg">
                    Partner with top artists, movie studios, and content creators. Earn every time you engage.
                </p>
            </div>

            <div class="grid gap-4 md:gap-8 lg:grid-cols-2">
                {{-- Audio Collaboration --}}
                <div class="group overflow-hidden rounded-xl border border-[#315150]/50 bg-[#1a2f2f]/20 transition-all hover:border-[#315150]/50 md:rounded-2xl">
                    <img src="/images/stream/audio-collab.jpg" alt="Audio Collaboration" class="w-full">
                </div>

                {{-- Video Collaboration --}}
                <div class="group overflow-hidden rounded-xl border border-[#315150]/50 bg-[#1a2f2f]/20 transition-all hover:border-[#315150]/50 md:rounded-2xl">
                    <img src="/images/stream/video-collab.jpg" alt="Video Collaboration" class="w-full">
                </div>
            </div>
        </div>
    </section>

    {{-- Earnings Section --}}
    <section id="earnings" class="bg-[#0a1f1f] py-12 md:py-24">
        <div class="mx-auto max-w-7xl px-4 md:px-6">
            <div class="grid items-center gap-8 md:gap-12 lg:grid-cols-2">
                {{-- Content --}}
                <div>
                    <span class="mb-3 inline-block rounded-full bg-[#315150]/10 px-3 py-1 text-xs font-medium text-[#3d6363] md:mb-4 md:px-4 md:text-sm">Earnings</span>
                    <h2 class="mb-4 text-2xl font-bold text-white md:mb-6 md:text-4xl lg:text-5xl">Earning Based on Duration</h2>
                    <p class="mb-6 text-base font-semibold text-[#3d6363] md:mb-8 md:text-xl">Easy Stream. Easy Cash.</p>

                    <div class="space-y-3 md:space-y-4">
                        {{-- Audio Collab --}}
                        <div class="rounded-lg border border-[#315150]/50 bg-[#1a2f2f]/20 p-3 md:rounded-xl md:p-4">
                            <div class="flex items-center gap-3 md:gap-4">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#315150]/20 md:h-12 md:w-12">
                                    <svg class="h-5 w-5 text-[#3d6363] md:h-6 md:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-sm font-semibold text-white md:text-base">Audio Collab</h4>
                                    <p class="text-xs text-gray-400 md:text-sm">30 secs = <span class="font-bold text-[#3d6363]">₦1,550</span> | 3-min = <span class="font-bold text-[#3d6363]">₦9,300</span></p>
                                </div>
                            </div>
                        </div>

                        {{-- Video Collab --}}
                        <div class="rounded-lg border border-[#315150]/50 bg-[#1a2f2f]/20 p-3 md:rounded-xl md:p-4">
                            <div class="flex items-center gap-3 md:gap-4">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#315150]/20 md:h-12 md:w-12">
                                    <svg class="h-5 w-5 text-[#3d6363] md:h-6 md:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-sm font-semibold text-white md:text-base">Video Collab</h4>
                                    <p class="text-xs text-gray-400 md:text-sm">60 secs = <span class="font-bold text-[#3d6363]">₦2,750</span> | 5-min = <span class="font-bold text-[#3d6363]">₦13,750</span></p>
                                </div>
                            </div>
                        </div>

                        {{-- Livestream Collab --}}
                        <div class="rounded-lg border border-[#315150]/50 bg-[#1a2f2f]/20 p-3 md:rounded-xl md:p-4">
                            <div class="flex items-center gap-3 md:gap-4">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#315150]/20 md:h-12 md:w-12">
                                    <svg class="h-5 w-5 text-[#3d6363] md:h-6 md:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-sm font-semibold text-white md:text-base">Livestream Collab</h4>
                                    <p class="text-xs text-gray-400 md:text-sm">2 mins = <span class="font-bold text-[#3d6363]">₦5,700</span> | 10 mins = <span class="font-bold text-[#3d6363]">₦28,500</span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="mt-4 text-xs text-gray-500 md:mt-6 md:text-sm">Just vibe, and your money keeps dropping. Press play. Let the cash flow.</p>
                </div>

                {{-- Image --}}
                <div>
                    <img src="/images/stream/earnings.jpg" alt="Earnings" class="w-full rounded-xl shadow-xl md:rounded-2xl">
                </div>
            </div>
        </div>
    </section>

    {{-- Certified Section --}}
    <section class="bg-[#081818] py-12 md:py-24">
        <div class="mx-auto max-w-7xl px-4 md:px-6">
            <div class="grid items-center gap-8 md:gap-12 lg:grid-cols-2">
                {{-- Image --}}
                <div>
                    <img src="/images/stream/certified.jpg" alt="Stream is Certified" class="w-full rounded-xl shadow-xl md:rounded-2xl">
                </div>

                {{-- Content --}}
                <div>
                    <span class="mb-3 inline-block rounded-full bg-green-500/10 px-3 py-1 text-xs font-medium text-green-400 md:mb-4 md:px-4 md:text-sm">Trust & Security</span>
                    <h2 class="mb-4 text-2xl font-bold text-white md:mb-6 md:text-4xl lg:text-5xl">Stream is <span class="text-green-400">Certified!</span></h2>
                    <p class="mb-4 text-sm leading-relaxed text-gray-400 md:mb-6 md:text-lg">
                        Stream Africa is a fully registered business under the Corporate Affairs Commission (CAC) of Nigeria. Registration No. 9093054.
                    </p>
                    <p class="mb-6 text-sm text-gray-400 md:mb-8 md:text-base">
                        Our certification ensures that you're partnering with a legitimate, transparent, and accountable organization.
                    </p>

                    <div class="flex flex-wrap gap-2 md:gap-4">
                        <div class="flex items-center gap-2 rounded-lg bg-green-500/10 px-3 py-2 text-green-400">
                            <svg class="h-4 w-4 md:h-5 md:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span class="text-xs font-medium md:text-sm">CAC Registered</span>
                        </div>
                        <div class="flex items-center gap-2 rounded-lg bg-green-500/10 px-3 py-2 text-green-400">
                            <svg class="h-4 w-4 md:h-5 md:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <span class="text-xs font-medium md:text-sm">Secure</span>
                        </div>
                        <div class="flex items-center gap-2 rounded-lg bg-green-500/10 px-3 py-2 text-green-400">
                            <svg class="h-4 w-4 md:h-5 md:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span class="text-xs font-medium md:text-sm">Fast Withdrawals</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Pricing Section --}}
    <section id="pricing" class="bg-linear-to-b from-[#081818] to-[#0a1f1f] py-12 md:py-24">
        <div class="mx-auto max-w-7xl px-4 md:px-6">
            <div class="mb-8 text-center md:mb-16">
                    <span class="mb-3 inline-block rounded-full bg-[#315150]/10 px-3 py-1 text-xs font-medium text-[#3d6363] md:mb-4 md:px-4 md:text-sm">Membership</span>
                <h2 class="mb-3 text-2xl font-bold text-white md:mb-4 md:text-4xl lg:text-5xl">Membership Pricing</h2>
                <p class="mx-auto max-w-2xl text-sm text-gray-400 md:text-lg">
                    One-time onboarding fee. Lifetime access to earnings.
                </p>
            </div>

            <div class="grid items-center gap-8 md:gap-12 lg:grid-cols-2">
                {{-- Pricing Image --}}
                <div>
                    <img src="/images/stream/pricing.jpg" alt="Membership Pricing" class="w-full rounded-xl shadow-xl md:rounded-2xl">
                </div>

                {{-- Pricing Details --}}
                <div>
                    <div class="rounded-xl border-2 border-[#315150] bg-linear-to-b from-[#1a2f2f]/30 to-[#081818] p-4 md:rounded-2xl md:p-8">
                        <div class="mb-4 md:mb-6">
                            <span class="text-xs text-gray-400 md:text-sm">Onboarding Fee</span>
                            <div class="text-3xl font-bold text-white md:text-5xl">₦12,000</div>
                        </div>

                        <div class="mb-6 space-y-3 md:mb-8 md:space-y-4">
                            <h4 class="text-sm font-semibold text-[#3d6363] md:text-base">What You Get:</h4>
                            <ul class="space-y-2 md:space-y-3">
                                @php
                                    $benefits = [
                                        ['text' => 'Stream Cashback', 'value' => '₦12,000 (100%)'],
                                        ['text' => 'Stream Partner Bonus', 'value' => '₦10,200'],
                                        ['text' => 'LiveStream Collab', 'value' => '₦5,700'],
                                        ['text' => 'Video Collab', 'value' => '₦2,750'],
                                        ['text' => 'Audio Collab', 'value' => '₦1,550'],
                                        ['text' => 'Access to Stream SkillUp', 'value' => null],
                                        ['text' => 'Access to Stream Bazaar', 'value' => null],
                                    ];
                                @endphp
                                @foreach ($benefits as $benefit)
                                    <li class="flex items-start gap-2 text-xs text-gray-300 md:gap-3 md:text-sm">
                                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-[#315150] md:h-5 md:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>{{ $benefit['text'] }} @if($benefit['value']) - <span class="text-[#3d6363]">{{ $benefit['value'] }}</span>@endif</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="mb-4 rounded-lg bg-teal-500/10 p-3 text-center md:mb-6 md:p-4">
                            <p class="text-xs text-[#4a7575] md:text-sm">TikTok Creator's Network = <span class="font-bold">₦200,000 monthly</span></p>
                        </div>

                        <a href="{{ route('register') }}" wire:navigate class="block w-full rounded-lg bg-linear-to-r from-[#315150] to-[#3d6363] px-4 py-3 text-center text-sm font-semibold text-white shadow-lg shadow-[#315150]/25 transition-all hover:scale-105 md:rounded-xl md:px-6 md:py-4 md:text-lg">
                            Join Stream Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Skills Section --}}
    <section class="bg-[#0a1f1f] py-12 md:py-24">
        <div class="mx-auto max-w-7xl px-4 md:px-6">
            <div class="mb-8 text-center md:mb-16">
                <span class="mb-3 inline-block rounded-full bg-[#315150]/10 px-3 py-1 text-xs font-medium text-[#3d6363] md:mb-4 md:px-4 md:text-sm">Stream SkillUp</span>
                <h2 class="mb-3 text-2xl font-bold text-white md:mb-4 md:text-4xl lg:text-5xl">High-Income Skills</h2>
                <p class="mx-auto max-w-2xl text-sm text-gray-400 md:text-lg">
                    Access our curated collection of skills designed to position you for real success.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-2 md:grid-cols-3 md:gap-4 lg:grid-cols-5">
                @php
                    $skills = [
                        'Dropshipping',
                        'Copywriting',
                        'UI/UX Design',
                        'Web Dev',
                        'App Dev',
                        'Graphics Design',
                        'YouTube Auto',
                        'Social Media',
                        'Digital Marketing',
                        'MS Office',
                    ];
                @endphp

                @foreach ($skills as $skill)
                    <div class="rounded-lg border border-[#315150]/50 bg-[#1a2f2f]/20 px-3 py-3 text-center transition-all hover:border-[#315150]/50 hover:bg-[#1a2f2f]/30 md:rounded-xl md:px-4 md:py-4">
                        <span class="text-xs font-medium text-white md:text-sm">{{ $skill }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="relative overflow-hidden bg-linear-to-br from-[#1a2f2f] via-[#2a3f3f] to-[#1a2f2f] py-12 md:py-24">
        <div class="absolute inset-0">
            <div class="absolute left-1/4 top-0 h-40 w-40 rounded-full bg-[#315150]/20 blur-3xl md:h-96 md:w-96"></div>
            <div class="absolute bottom-0 right-1/4 h-40 w-40 rounded-full bg-[#2a4040]/20 blur-3xl md:h-96 md:w-96"></div>
        </div>

        <div class="relative mx-auto max-w-4xl px-4 text-center md:px-6">
            <h2 class="mb-3 text-xl font-bold uppercase tracking-wide text-white md:mb-4 md:text-3xl lg:text-4xl">
                Upgrade Your Knowledge.<br>Upgrade Your Income.
            </h2>
            <p class="mb-6 text-base font-semibold text-[#3d6363] md:mb-10 md:text-xl">
                Get Onboard Today.
            </p>
            <a href="{{ route('register') }}" wire:navigate class="inline-flex items-center justify-center gap-2 rounded-lg bg-linear-to-r from-[#315150] to-[#3d6363] px-6 py-3 text-sm font-semibold text-white shadow-xl shadow-[#315150]/25 transition-all hover:scale-105 md:rounded-xl md:px-8 md:py-4 md:text-lg">
                Start Earning Now
                <svg class="h-4 w-4 md:h-5 md:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-[#061212] py-10 md:py-16">
        <div class="mx-auto max-w-7xl px-4 md:px-6">
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                {{-- Brand --}}
                <div>
                    <div class="mb-3 flex items-center gap-2 md:mb-4">
                        <svg class="h-6 w-6 text-[#3d6363] md:h-8 md:w-8" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3 7h18v2H3V7zm0 4h18v2H3v-2zm0 4h12v2H3v-2z"/>
                        </svg>
                        <span class="text-xl font-bold text-white md:text-2xl">Stream</span>
                    </div>
                    <p class="mb-4 text-sm text-gray-400 md:mb-6">Redefining how Africans experience and earn from entertainment.</p>
                    <div class="flex gap-3 md:gap-4">
                        <a href="#" class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#1a2f2f]/50 text-gray-400 transition-colors hover:bg-[#315150]/50 hover:text-white md:h-10 md:w-10">
                            <svg class="h-4 w-4 md:h-5 md:w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#1a2f2f]/50 text-gray-400 transition-colors hover:bg-[#315150]/50 hover:text-white md:h-10 md:w-10">
                            <svg class="h-4 w-4 md:h-5 md:w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.295-.6.295-.002 0-.003 0-.005 0l.213-3.054 5.56-5.022c.24-.213-.054-.334-.373-.121l-6.869 4.326-2.96-.924c-.64-.203-.658-.64.135-.954l11.566-4.458c.538-.196 1.006.128.832.941z"/></svg>
                        </a>
                        <a href="#" class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#1a2f2f]/50 text-gray-400 transition-colors hover:bg-[#315150]/50 hover:text-white md:h-10 md:w-10">
                            <svg class="h-4 w-4 md:h-5 md:w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h4 class="mb-3 text-sm font-semibold text-white md:mb-4 md:text-base">Quick Links</h4>
                    <ul class="space-y-2 md:space-y-3">
                        <li><a href="#about" class="text-sm text-gray-400 transition-colors hover:text-[#3d6363]">About Us</a></li>
                        <li><a href="#earnings" class="text-sm text-gray-400 transition-colors hover:text-[#3d6363]">Earnings</a></li>
                        <li><a href="#pricing" class="text-sm text-gray-400 transition-colors hover:text-[#3d6363]">Pricing</a></li>
                        <li><a href="#" class="text-sm text-gray-400 transition-colors hover:text-[#3d6363]">SkillUp</a></li>
                    </ul>
                </div>

                {{-- Collaborations --}}
                <div>
                    <h4 class="mb-3 text-sm font-semibold text-white md:mb-4 md:text-base">Collaborations</h4>
                    <ul class="space-y-2 md:space-y-3">
                        <li><a href="#" class="text-sm text-gray-400 transition-colors hover:text-[#3d6363]">Audio Collab</a></li>
                        <li><a href="#" class="text-sm text-gray-400 transition-colors hover:text-[#3d6363]">Video Collab</a></li>
                        <li><a href="#" class="text-sm text-gray-400 transition-colors hover:text-[#3d6363]">Livestream</a></li>
                        <li><a href="#" class="text-sm text-gray-400 transition-colors hover:text-[#3d6363]">Stream Bazaar</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h4 class="mb-3 text-sm font-semibold text-white md:mb-4 md:text-base">Contact</h4>
                    <ul class="space-y-2 md:space-y-3">
                        <li class="text-sm text-gray-400">@officialstreamafrica</li>
                        <li><a href="#" class="text-sm text-gray-400 transition-colors hover:text-[#3d6363]">Help Center</a></li>
                        <li><a href="#" class="text-sm text-gray-400 transition-colors hover:text-[#3d6363]">Privacy Policy</a></li>
                        <li><a href="#" class="text-sm text-gray-400 transition-colors hover:text-[#3d6363]">Terms</a></li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 border-t border-[#315150] pt-6 text-center md:mt-12 md:pt-8">
                <p class="text-xs text-gray-400 md:text-sm">&copy; {{ date('Y') }} Stream Africa. All rights reserved. CAC Reg: 9093054</p>
            </div>
        </div>
    </footer>
</div>
