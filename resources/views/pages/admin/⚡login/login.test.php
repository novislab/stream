<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::findOrCreate('admin');
});

it('renders successfully', function () {
    Livewire::test('pages::admin.login')
        ->assertStatus(200);
});

it('uses admin layout', function () {
    Livewire::test('pages::admin.login')
        ->assertStatus(200);
});

it('has admin login title', function () {
    Livewire::test('pages::admin.login')
        ->assertSee('Admin Login');
});

it('shows email input', function () {
    Livewire::test('pages::admin.login')
        ->assertSeeHtml('data-test="email-input"');
});

it('shows password input', function () {
    Livewire::test('pages::admin.login')
        ->assertSeeHtml('data-test="password-input"');
});

it('shows remember checkbox', function () {
    Livewire::test('pages::admin.login')
        ->assertSeeHtml('data-test="remember-checkbox"');
});

it('shows login button', function () {
    Livewire::test('pages::admin.login')
        ->assertSeeHtml('data-test="login-button"');
});

it('requires email and password', function () {
    Livewire::test('pages::admin.login')
        ->set('email', '')
        ->set('password', '')
        ->call('login')
        ->assertNoRedirect();
});

it('rejects invalid credentials', function () {
    Livewire::test('pages::admin.login')
        ->set('email', 'wrong@email.com')
        ->set('password', 'wrongpassword')
        ->call('login')
        ->assertNoRedirect();
});

it('rejects non-admin user', function () {
    $user = User::factory()->create([
        'password' => 'password123',
    ]);

    Livewire::test('pages::admin.login')
        ->set('email', $user->email)
        ->set('password', 'password123')
        ->call('login')
        ->assertNoRedirect();

    expect(Auth::check())->toBeFalse();
});

it('allows admin user to login', function () {
    $user = User::factory()->create([
        'password' => 'password123',
    ]);
    $user->assignRole('admin');

    Livewire::test('pages::admin.login')
        ->set('email', $user->email)
        ->set('password', 'password123')
        ->call('login')
        ->assertRedirect(route('admin.dashboard'));

    expect(Auth::check())->toBeTrue();
    expect(Auth::id())->toBe($user->id);
});

it('remembers user when checkbox is checked', function () {
    $user = User::factory()->create([
        'password' => 'password123',
    ]);
    $user->assignRole('admin');

    Livewire::test('pages::admin.login')
        ->set('email', $user->email)
        ->set('password', 'password123')
        ->set('remember', true)
        ->call('login')
        ->assertRedirect(route('admin.dashboard'));

    expect(Auth::check())->toBeTrue();
});
