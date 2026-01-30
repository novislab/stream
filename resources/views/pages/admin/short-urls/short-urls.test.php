<?php

use App\Models\ShortUrl;
use App\Models\UrlVisit;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::findOrCreate('admin');
});

describe('component tests', function () {
    it('renders successfully', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.short-urls')
            ->assertStatus(200);
    });

    it('displays short url manager heading', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.short-urls')
            ->assertSee('Short URL Manager');
    });

    it('can create a short url', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.short-urls')
            ->set('originalUrl', 'https://example.com/test')
            ->set('title', 'Test Link')
            ->call('createShortUrl')
            ->assertHasNoErrors();

        expect(ShortUrl::where('original_url', 'https://example.com/test')->exists())->toBeTrue();
    });

    it('can create a short url with max views', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.short-urls')
            ->set('originalUrl', 'https://example.com/test')
            ->set('maxViews', 100)
            ->call('createShortUrl')
            ->assertHasNoErrors();

        $shortUrl = ShortUrl::where('original_url', 'https://example.com/test')->first();
        expect($shortUrl->max_views)->toBe(100);
    });

    it('validates url is required', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.short-urls')
            ->set('originalUrl', '')
            ->call('createShortUrl')
            ->assertHasErrors(['originalUrl' => 'required']);
    });

    it('validates url format', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.short-urls')
            ->set('originalUrl', 'not-a-valid-url')
            ->call('createShortUrl')
            ->assertHasErrors(['originalUrl' => 'url']);
    });

    it('validates max views must be positive', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.short-urls')
            ->set('originalUrl', 'https://example.com')
            ->set('maxViews', 0)
            ->call('createShortUrl')
            ->assertHasErrors(['maxViews' => 'min']);
    });

    it('displays existing short urls', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $shortUrl = ShortUrl::factory()->create([
            'title' => 'My Test URL',
            'original_url' => 'https://example.com',
        ]);

        Livewire::actingAs($user)
            ->test('pages::admin.short-urls')
            ->assertSee('My Test URL')
            ->assertSee($shortUrl->code);
    });

    it('can toggle short url active status', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $shortUrl = ShortUrl::factory()->create(['is_active' => true]);

        Livewire::actingAs($user)
            ->test('pages::admin.short-urls')
            ->call('toggleActive', $shortUrl->id);

        expect($shortUrl->fresh()->is_active)->toBeFalse();
    });

    it('can delete a short url', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $shortUrl = ShortUrl::factory()->create();
        $id = $shortUrl->id;

        Livewire::actingAs($user)
            ->test('pages::admin.short-urls')
            ->call('deleteShortUrl', $id);

        expect(ShortUrl::find($id))->toBeNull();
    });

    it('can edit a short url', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $shortUrl = ShortUrl::factory()->create([
            'original_url' => 'https://old-url.com',
            'title' => 'Old Title',
            'max_views' => 50,
        ]);

        Livewire::actingAs($user)
            ->test('pages::admin.short-urls')
            ->call('editShortUrl', $shortUrl->id)
            ->assertSet('editingId', $shortUrl->id)
            ->assertSet('originalUrl', 'https://old-url.com')
            ->assertSet('title', 'Old Title')
            ->assertSet('maxViews', 50);
    });

    it('can update a short url', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $shortUrl = ShortUrl::factory()->create([
            'original_url' => 'https://old-url.com',
            'title' => 'Old Title',
            'max_views' => 50,
        ]);

        Livewire::actingAs($user)
            ->test('pages::admin.short-urls')
            ->call('editShortUrl', $shortUrl->id)
            ->set('originalUrl', 'https://new-url.com')
            ->set('title', 'New Title')
            ->set('maxViews', 200)
            ->call('updateShortUrl');

        $shortUrl->refresh();
        expect($shortUrl->original_url)->toBe('https://new-url.com');
        expect($shortUrl->title)->toBe('New Title');
        expect($shortUrl->max_views)->toBe(200);
    });

    it('can cancel edit', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $shortUrl = ShortUrl::factory()->create();

        Livewire::actingAs($user)
            ->test('pages::admin.short-urls')
            ->call('editShortUrl', $shortUrl->id)
            ->call('cancelEdit')
            ->assertSet('editingId', null)
            ->assertSet('originalUrl', '')
            ->assertSet('maxViews', null);
    });

    it('shows click count for short urls', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        ShortUrl::factory()->create(['click_count' => 42]);

        Livewire::actingAs($user)
            ->test('pages::admin.short-urls')
            ->assertSee('42');
    });

    it('shows max views when set', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        ShortUrl::factory()->create(['click_count' => 10, 'max_views' => 100]);

        Livewire::actingAs($user)
            ->test('pages::admin.short-urls')
            ->assertSee('/ 100');
    });

    it('shows active badge for active urls', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        ShortUrl::factory()->create(['is_active' => true]);

        Livewire::actingAs($user)
            ->test('pages::admin.short-urls')
            ->assertSee('Active');
    });

    it('shows inactive badge for inactive urls', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        ShortUrl::factory()->create(['is_active' => false]);

        Livewire::actingAs($user)
            ->test('pages::admin.short-urls')
            ->assertSee('Inactive');
    });

    it('shows expired badge for expired urls', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        ShortUrl::factory()->create([
            'is_active' => true,
            'expires_at' => now()->subDay(),
        ]);

        Livewire::actingAs($user)
            ->test('pages::admin.short-urls')
            ->assertSee('Expired');
    });

    it('shows max reached badge when max views reached', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        ShortUrl::factory()->maxViewsReached()->create();

        Livewire::actingAs($user)
            ->test('pages::admin.short-urls')
            ->assertSee('Max Reached');
    });

    it('resets form after creating short url', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.short-urls')
            ->set('originalUrl', 'https://example.com')
            ->set('title', 'Test')
            ->set('maxViews', 100)
            ->call('createShortUrl')
            ->assertSet('originalUrl', '')
            ->assertSet('title', null)
            ->assertSet('maxViews', null);
    });
});

describe('show page tests', function () {
    it('renders show page successfully', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $shortUrl = ShortUrl::factory()->create();

        Livewire::actingAs($user)
            ->test('pages::admin.short-urls.show', ['shortUrl' => $shortUrl])
            ->assertStatus(200);
    });

    it('displays short url statistics', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $shortUrl = ShortUrl::factory()->create([
            'title' => 'Test Stats URL',
            'click_count' => 150,
        ]);

        Livewire::actingAs($user)
            ->test('pages::admin.short-urls.show', ['shortUrl' => $shortUrl])
            ->assertSee('Test Stats URL')
            ->assertSee('150');
    });

    it('displays max views on show page', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $shortUrl = ShortUrl::factory()->create(['max_views' => 500]);

        Livewire::actingAs($user)
            ->test('pages::admin.short-urls.show', ['shortUrl' => $shortUrl])
            ->assertSee('500');
    });

    it('shows unlimited when max views is null', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $shortUrl = ShortUrl::factory()->create(['max_views' => null]);

        Livewire::actingAs($user)
            ->test('pages::admin.short-urls.show', ['shortUrl' => $shortUrl])
            ->assertSee('∞');
    });

    it('displays recent visits', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $shortUrl = ShortUrl::factory()->create();
        UrlVisit::factory()->create([
            'short_url_id' => $shortUrl->id,
            'browser' => 'Chrome',
            'device' => 'Desktop',
        ]);

        Livewire::actingAs($user)
            ->test('pages::admin.short-urls.show', ['shortUrl' => $shortUrl])
            ->assertSee('Chrome')
            ->assertSee('Desktop');
    });
});

describe('redirect tests', function () {
    it('redirects to original url', function () {
        $shortUrl = ShortUrl::factory()->withoutUser()->create([
            'original_url' => 'https://example.com/test-page',
            'is_active' => true,
        ]);

        $response = test()->get('/s/'.$shortUrl->code);

        $response->assertRedirect('https://example.com/test-page');
    });

    it('increments click count on redirect', function () {
        $shortUrl = ShortUrl::factory()->withoutUser()->create([
            'click_count' => 0,
            'is_active' => true,
        ]);

        test()->get('/s/'.$shortUrl->code);

        expect($shortUrl->fresh()->click_count)->toBe(1);
    });

    it('records visit data on redirect', function () {
        $shortUrl = ShortUrl::factory()->withoutUser()->create(['is_active' => true]);

        test()->get('/s/'.$shortUrl->code);

        expect(UrlVisit::where('short_url_id', $shortUrl->id)->count())->toBe(1);
    });

    it('returns 404 for inactive short url', function () {
        $shortUrl = ShortUrl::factory()->withoutUser()->inactive()->create();

        $response = test()->get('/s/'.$shortUrl->code);

        $response->assertNotFound();
    });

    it('returns 404 for expired short url', function () {
        $shortUrl = ShortUrl::factory()->withoutUser()->expired()->create();

        $response = test()->get('/s/'.$shortUrl->code);

        $response->assertNotFound();
    });

    it('returns 404 for max views reached', function () {
        $shortUrl = ShortUrl::factory()->withoutUser()->maxViewsReached()->create();

        $response = test()->get('/s/'.$shortUrl->code);

        $response->assertNotFound();
    });

    it('returns 404 for nonexistent code', function () {
        $response = test()->get('/s/nonexistent');

        $response->assertNotFound();
    });
});

describe('model tests', function () {
    it('generates unique code automatically', function () {
        $shortUrl = ShortUrl::create([
            'original_url' => 'https://example.com',
        ]);

        expect($shortUrl->code)->not->toBeEmpty()
            ->and(strlen((string) $shortUrl->code))->toBe(6);
    });

    it('can have custom code', function () {
        $shortUrl = ShortUrl::create([
            'original_url' => 'https://example.com',
            'code' => 'custom',
        ]);

        expect($shortUrl->code)->toBe('custom');
    });

    it('is accessible returns true for active non-expired url', function () {
        $shortUrl = ShortUrl::factory()->withoutUser()->create([
            'is_active' => true,
            'expires_at' => now()->addDay(),
        ]);

        expect($shortUrl->isAccessible())->toBeTrue();
    });

    it('is accessible returns false for inactive url', function () {
        $shortUrl = ShortUrl::factory()->withoutUser()->inactive()->create();

        expect($shortUrl->isAccessible())->toBeFalse();
    });

    it('is accessible returns false for expired url', function () {
        $shortUrl = ShortUrl::factory()->withoutUser()->expired()->create();

        expect($shortUrl->isAccessible())->toBeFalse();
    });

    it('is accessible returns false when max views reached', function () {
        $shortUrl = ShortUrl::factory()->withoutUser()->maxViewsReached()->create();

        expect($shortUrl->isAccessible())->toBeFalse();
    });

    it('has reached max views returns true when limit hit', function () {
        $shortUrl = ShortUrl::factory()->withoutUser()->create([
            'max_views' => 10,
            'click_count' => 10,
        ]);

        expect($shortUrl->hasReachedMaxViews())->toBeTrue();
    });

    it('has reached max views returns false when under limit', function () {
        $shortUrl = ShortUrl::factory()->withoutUser()->create([
            'max_views' => 10,
            'click_count' => 5,
        ]);

        expect($shortUrl->hasReachedMaxViews())->toBeFalse();
    });

    it('has reached max views returns false when no limit set', function () {
        $shortUrl = ShortUrl::factory()->withoutUser()->create([
            'max_views' => null,
            'click_count' => 1000,
        ]);

        expect($shortUrl->hasReachedMaxViews())->toBeFalse();
    });

    it('generates short url attribute', function () {
        $shortUrl = ShortUrl::factory()->withoutUser()->create(['code' => 'abc123']);

        expect($shortUrl->short_url)->toContain('s/abc123');
    });

    it('has many visits relationship', function () {
        $shortUrl = ShortUrl::factory()->withoutUser()->create();
        UrlVisit::factory()->count(3)->create(['short_url_id' => $shortUrl->id]);

        expect($shortUrl->visits)->toHaveCount(3);
    });

    it('belongs to user relationship', function () {
        $user = User::factory()->create();
        $shortUrl = ShortUrl::factory()->create(['user_id' => $user->id]);

        expect($shortUrl->user->id)->toBe($user->id);
    });
});
