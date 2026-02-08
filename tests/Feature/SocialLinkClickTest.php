<?php

use App\Models\Payment;
use App\Models\SocialLink;
use App\Models\SocialLinkClick;

test('social link click model can be created', function () {
    $socialLink = SocialLink::factory()->create([
        'platform' => 'facebook',
        'url' => 'https://facebook.com/test',
    ]);

    $click = SocialLinkClick::create([
        'social_link_id' => $socialLink->id,
        'ip_address' => '192.168.1.1',
        'user_agent' => 'Mozilla/5.0',
        'referer' => 'https://example.com',
    ]);

    expect($click->exists)->toBeTrue();
    expect($click->socialLink->is($socialLink))->toBeTrue();
});

test('social link has clicks relationship', function () {
    $socialLink = SocialLink::factory()->create([
        'platform' => 'instagram',
        'url' => 'https://instagram.com/test',
    ]);

    SocialLinkClick::factory()->count(3)->create([
        'social_link_id' => $socialLink->id,
    ]);

    expect($socialLink->clicks()->count())->toBe(3);
    expect($socialLink->clickCount())->toBe(3);
});

test('social link click count returns zero when no clicks', function () {
    $socialLink = SocialLink::factory()->create([
        'platform' => 'twitter',
        'url' => 'https://twitter.com/test',
    ]);

    expect($socialLink->clickCount())->toBe(0);
});

test('payment model can be created', function () {
    $payment = Payment::create([
        'amount' => 12000.00,
        'status' => 'completed',
        'transaction_id' => 'TXN123456',
        'bank_name' => 'Test Bank',
        'account_number' => '1234567890',
    ]);

    expect($payment->exists)->toBeTrue();
    expect((float) $payment->amount)->toBe(12000.0);
    expect($payment->status)->toBe('completed');
});
