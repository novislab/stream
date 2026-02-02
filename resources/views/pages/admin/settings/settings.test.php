<?php

use App\Models\Setting;
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
            ->test('pages::admin.settings')
            ->assertStatus(200);
    });

    it('displays settings heading', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.settings')
            ->assertSee('Settings');
    });

    it('loads existing settings on mount', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Setting::set('app_name', 'Test App');
        Setting::set('whatsapp_link', 'https://wa.me/1234567890');
        Setting::set('telegram_link', 'https://t.me/testuser');

        Livewire::actingAs($user)
            ->test('pages::admin.settings')
            ->assertSet('appName', 'Test App')
            ->assertSet('whatsappLink', 'https://wa.me/1234567890')
            ->assertSet('telegramLink', 'https://t.me/testuser');
    });

    it('loads default app name from config when not set', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.settings')
            ->assertSet('appName', config('app.name'));
    });

    it('can save settings', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.settings')
            ->set('appName', 'My New App')
            ->set('whatsappLink', 'https://wa.me/9876543210')
            ->set('telegramLink', 'https://t.me/newuser')
            ->call('save')
            ->assertHasNoErrors();

        expect(Setting::get('app_name'))->toBe('My New App');
        expect(Setting::get('whatsapp_link'))->toBe('https://wa.me/9876543210');
        expect(Setting::get('telegram_link'))->toBe('https://t.me/newuser');
    });

    it('validates app name is required', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.settings')
            ->set('appName', '')
            ->call('save')
            ->assertHasErrors(['appName' => 'required']);
    });

    it('validates whatsapp link is a valid url', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.settings')
            ->set('appName', 'Test App')
            ->set('whatsappLink', 'not-a-valid-url')
            ->call('save')
            ->assertHasErrors(['whatsappLink' => 'url']);
    });

    it('validates telegram link is a valid url', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.settings')
            ->set('appName', 'Test App')
            ->set('telegramLink', 'not-a-valid-url')
            ->call('save')
            ->assertHasErrors(['telegramLink' => 'url']);
    });

    it('allows empty whatsapp link', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.settings')
            ->set('appName', 'Test App')
            ->set('whatsappLink')
            ->call('save')
            ->assertHasNoErrors(['whatsappLink']);
    });

    it('allows empty telegram link', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.settings')
            ->set('appName', 'Test App')
            ->set('telegramLink')
            ->call('save')
            ->assertHasNoErrors(['telegramLink']);
    });

});

describe('model tests', function () {
    it('can get setting value', function () {
        Setting::create(['key' => 'test_key', 'value' => 'test_value']);

        expect(Setting::get('test_key'))->toBe('test_value');
    });

    it('returns default when setting not found', function () {
        expect(Setting::get('nonexistent_key', 'default'))->toBe('default');
    });

    it('returns null when setting not found and no default', function () {
        expect(Setting::get('nonexistent_key'))->toBeNull();
    });

    it('can set setting value', function () {
        Setting::set('new_key', 'new_value');

        expect(Setting::get('new_key'))->toBe('new_value');
    });

    it('can update existing setting value', function () {
        Setting::set('update_key', 'old_value');
        Setting::set('update_key', 'new_value');

        expect(Setting::get('update_key'))->toBe('new_value');
        expect(Setting::where('key', 'update_key')->count())->toBe(1);
    });
});

describe('route tests', function () {
    it('redirects to login when not authenticated', function () {
        $response = test()->get('/admin/settings');

        $response->assertRedirect('/admin/login');
    });

    it('returns 403 for non-admin users', function () {
        $user = User::factory()->create();

        $response = test()
            ->actingAs($user)
            ->get('/admin/settings');

        $response->assertForbidden();
    });

    it('allows access for admin users', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $response = test()
            ->actingAs($user)
            ->get('/admin/settings');

        $response->assertOk();
    });
});
