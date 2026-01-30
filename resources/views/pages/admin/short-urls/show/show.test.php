<?php

/** @var Tests\TestCase $this */

use App\Models\ShortUrl;
use App\Models\UrlVisit;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::findOrCreate('admin');
});

it('renders successfully', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    $shortUrl = ShortUrl::factory()->create();

    Livewire::actingAs($user)
        ->test('pages::admin.short-urls.show', ['shortUrl' => $shortUrl])
        ->assertStatus(200);
});

it('displays short url title', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    $shortUrl = ShortUrl::factory()->create(['title' => 'My Test Link']);

    Livewire::actingAs($user)
        ->test('pages::admin.short-urls.show', ['shortUrl' => $shortUrl])
        ->assertSee('My Test Link');
});

it('displays click count', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    $shortUrl = ShortUrl::factory()->create(['click_count' => 999]);

    Livewire::actingAs($user)
        ->test('pages::admin.short-urls.show', ['shortUrl' => $shortUrl])
        ->assertSee('999');
});

it('displays max views when set', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    $shortUrl = ShortUrl::factory()->create(['max_views' => 500]);

    Livewire::actingAs($user)
        ->test('pages::admin.short-urls.show', ['shortUrl' => $shortUrl])
        ->assertSee('500');
});

it('displays infinity symbol when no max views', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    $shortUrl = ShortUrl::factory()->create(['max_views' => null]);

    Livewire::actingAs($user)
        ->test('pages::admin.short-urls.show', ['shortUrl' => $shortUrl])
        ->assertSee('∞');
});

it('displays original url', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    $shortUrl = ShortUrl::factory()->create(['original_url' => 'https://example.com/my-page']);

    Livewire::actingAs($user)
        ->test('pages::admin.short-urls.show', ['shortUrl' => $shortUrl])
        ->assertSee('https://example.com/my-page');
});

it('displays active badge for active url', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    $shortUrl = ShortUrl::factory()->create(['is_active' => true]);

    Livewire::actingAs($user)
        ->test('pages::admin.short-urls.show', ['shortUrl' => $shortUrl])
        ->assertSee('Active');
});

it('displays expired badge for expired url', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    $shortUrl = ShortUrl::factory()->expired()->create();

    Livewire::actingAs($user)
        ->test('pages::admin.short-urls.show', ['shortUrl' => $shortUrl])
        ->assertSee('Expired');
});

it('displays max reached badge when max views reached', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    $shortUrl = ShortUrl::factory()->maxViewsReached()->create();

    Livewire::actingAs($user)
        ->test('pages::admin.short-urls.show', ['shortUrl' => $shortUrl])
        ->assertSee('Max Views Reached');
});

it('displays browser stats', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    $shortUrl = ShortUrl::factory()->create();
    UrlVisit::factory()->count(3)->create([
        'short_url_id' => $shortUrl->id,
        'browser' => 'Chrome',
    ]);

    Livewire::actingAs($user)
        ->test('pages::admin.short-urls.show', ['shortUrl' => $shortUrl])
        ->assertSee('Chrome')
        ->assertSee('Browsers');
});

it('displays device stats', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    $shortUrl = ShortUrl::factory()->create();
    UrlVisit::factory()->count(2)->create([
        'short_url_id' => $shortUrl->id,
        'device' => 'Mobile',
    ]);

    Livewire::actingAs($user)
        ->test('pages::admin.short-urls.show', ['shortUrl' => $shortUrl])
        ->assertSee('Mobile')
        ->assertSee('Devices');
});

it('displays platform stats', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    $shortUrl = ShortUrl::factory()->create();
    UrlVisit::factory()->create([
        'short_url_id' => $shortUrl->id,
        'platform' => 'Windows',
    ]);

    Livewire::actingAs($user)
        ->test('pages::admin.short-urls.show', ['shortUrl' => $shortUrl])
        ->assertSee('Windows')
        ->assertSee('Platforms');
});

it('displays recent visits table', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    $shortUrl = ShortUrl::factory()->create();
    UrlVisit::factory()->create([
        'short_url_id' => $shortUrl->id,
        'ip_address' => '192.168.1.100',
    ]);

    Livewire::actingAs($user)
        ->test('pages::admin.short-urls.show', ['shortUrl' => $shortUrl])
        ->assertSee('Recent Visits')
        ->assertSee('192.168.1.100');
});

it('shows no visits message when empty', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    $shortUrl = ShortUrl::factory()->create();

    Livewire::actingAs($user)
        ->test('pages::admin.short-urls.show', ['shortUrl' => $shortUrl])
        ->assertSee('No visits recorded yet');
});
