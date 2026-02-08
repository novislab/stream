<?php

declare(strict_types=1);

use App\Models\Bank;
use App\Models\Payment;
use App\Models\SocialLink;
use App\Models\SocialLinkClick;
use Livewire\Component;

new class extends Component
{
    public $banks;

    public $socialLinks;

    public function mount(): void
    {
        $this->banks = Bank::where('is_active', true)->get();
        $this->socialLinks = SocialLink::all();
    }

    public function recordPayment(): void
    {
        $randomBank = $this->banks->random();
        $randomSocialLink = $this->socialLinks->random();

        Payment::create([
            'amount' => 12000,
            'status' => 'completed',
            'transaction_id' => 'TXN'.time().strtoupper(bin2hex(random_bytes(4))),
            'bank_name' => $randomBank->bank_name,
            'account_number' => $randomBank->account_number,
        ]);

        SocialLinkClick::create([
            'social_link_id' => $randomSocialLink->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'referer' => request()->header('referer'),
        ]);

        $this->redirect($randomSocialLink->url, navigate: false);
    }
};
