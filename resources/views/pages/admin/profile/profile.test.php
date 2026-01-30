<?php

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
            ->test('pages::admin.profile')
            ->assertStatus(200);
    });

    it('displays profile heading', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.profile')
            ->assertSee('Profile');
    });

    it('loads user data on mount', function () {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.profile')
            ->assertSet('name', 'Test User')
            ->assertSet('email', 'test@example.com');
    });

    it('can update profile information', function () {
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
        ]);
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.profile')
            ->set('name', 'New Name')
            ->set('email', 'new@example.com')
            ->call('updateProfile')
            ->assertHasNoErrors();

        $user->refresh();
        expect($user->name)->toBe('New Name');
        expect($user->email)->toBe('new@example.com');
    });

    it('validates name is required', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.profile')
            ->set('name', '')
            ->call('updateProfile')
            ->assertHasErrors(['name' => 'required']);
    });

    it('validates email is required', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.profile')
            ->set('email', '')
            ->call('updateProfile')
            ->assertHasErrors(['email' => 'required']);
    });

    it('validates email format', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.profile')
            ->set('email', 'not-an-email')
            ->call('updateProfile')
            ->assertHasErrors(['email' => 'email']);
    });

    it('validates email is unique except for current user', function () {
        $otherUser = User::factory()->create(['email' => 'taken@example.com']);
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.profile')
            ->set('email', 'taken@example.com')
            ->call('updateProfile')
            ->assertHasErrors(['email' => 'unique']);
    });

    it('can update password', function () {
        $user = User::factory()->create([
            'password' => bcrypt('oldpassword'),
        ]);
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.profile')
            ->set('currentPassword', 'oldpassword')
            ->set('newPassword', 'newpassword123')
            ->set('newPasswordConfirmation', 'newpassword123')
            ->call('updatePassword')
            ->assertHasNoErrors();

        expect(password_verify('newpassword123', (string) $user->fresh()->password))->toBeTrue();
    });

    it('validates current password is correct', function () {
        $user = User::factory()->create([
            'password' => bcrypt('correctpassword'),
        ]);
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.profile')
            ->set('currentPassword', 'wrongpassword')
            ->set('newPassword', 'newpassword123')
            ->set('newPasswordConfirmation', 'newpassword123')
            ->call('updatePassword')
            ->assertHasErrors(['currentPassword']);
    });

    it('validates password confirmation matches', function () {
        $user = User::factory()->create([
            'password' => bcrypt('currentpassword'),
        ]);
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.profile')
            ->set('currentPassword', 'currentpassword')
            ->set('newPassword', 'newpassword123')
            ->set('newPasswordConfirmation', 'differentpassword')
            ->call('updatePassword')
            ->assertHasErrors(['newPassword']);
    });

    it('resets password fields after update', function () {
        $user = User::factory()->create([
            'password' => bcrypt('oldpassword'),
        ]);
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.profile')
            ->set('currentPassword', 'oldpassword')
            ->set('newPassword', 'newpassword123')
            ->set('newPasswordConfirmation', 'newpassword123')
            ->call('updatePassword')
            ->assertSet('currentPassword', '')
            ->assertSet('newPassword', '')
            ->assertSet('newPasswordConfirmation', '');
    });
});

describe('route tests', function () {
    it('redirects to login when not authenticated', function () {
        $response = test()->get('/admin/profile');

        $response->assertRedirect('/admin/login');
    });

    it('returns 403 for non-admin users', function () {
        $user = User::factory()->create();

        $response = test()
            ->actingAs($user)
            ->get('/admin/profile');

        $response->assertForbidden();
    });

    it('allows access for admin users', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $response = test()
            ->actingAs($user)
            ->get('/admin/profile');

        $response->assertOk();
    });
});

describe('logout tests', function () {
    it('logs out admin user', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        test()
            ->actingAs($user)
            ->post('/admin/logout')
            ->assertRedirect('/admin/login');

        test()->assertGuest();
    });

    it('redirects to login when not authenticated', function () {
        $response = test()->post('/admin/logout');

        $response->assertRedirect('/admin/login');
    });
});
