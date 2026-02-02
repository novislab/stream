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
            ->test('pages::admin.bank')
            ->assertStatus(200);
    });

    it('loads existing bank settings on mount', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Setting::set('bank', 'Test Bank');
        Setting::set('bank_account_name', 'John Doe');
        Setting::set('bank_account_number', '1234567890');

        Livewire::actingAs($user)
            ->test('pages::admin.bank')
            ->assertSet('bank', 'Test Bank')
            ->assertSet('accountName', 'John Doe')
            ->assertSet('accountNumber', '1234567890');
    });

    it('can save bank settings', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.bank')
            ->set('bank', 'My Bank')
            ->set('accountName', 'Jane Doe')
            ->set('accountNumber', '999888777')
            ->call('save')
            ->assertHasNoErrors();

        expect(Setting::get('bank'))->toBe('My Bank');
        expect(Setting::get('bank_account_name'))->toBe('Jane Doe');
        expect(Setting::get('bank_account_number'))->toBe('999888777');
    });

    it('validates required fields', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.bank')
            ->set('bank', '')
            ->set('accountName', '')
            ->set('accountNumber', '')
            ->call('save')
            ->assertHasErrors(['bank' => 'required', 'accountName' => 'required', 'accountNumber' => 'required']);
    });
});

describe('route tests', function () {
    it('redirects to login when not authenticated', function () {
        $response = test()->get('/admin/bank');

        $response->assertRedirect('/admin/login');
    });

    it('returns 403 for non-admin users', function () {
        $user = User::factory()->create();

        $response = test()
            ->actingAs($user)
            ->get('/admin/bank');

        $response->assertForbidden();
    });

    it('allows access for admin users', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $response = test()
            ->actingAs($user)
            ->get('/admin/bank');

        $response->assertOk();
    });
});
