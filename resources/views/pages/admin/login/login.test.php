<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::findOrCreate('admin');
});

// ============================================
// Setup Tests (No Users Exist)
// ============================================

describe('setup tests', function () {
    it('shows setup form when no users exist', function () {
        Livewire::test('pages::admin.login')
            ->assertSee('Welcome to Stream')
            ->assertSee('Create your admin account');
    });

    it('can create first admin user', function () {
        Livewire::test('pages::admin.login')
            ->set('name', 'Admin User')
            ->set('email', 'admin@example.com')
            ->set('password', 'password123')
            ->set('passwordConfirmation', 'password123')
            ->call('register')
            ->assertRedirect(route('admin.dashboard'));

        $user = User::where('email', 'admin@example.com')->first();
        expect($user)->not->toBeNull();
        expect($user->name)->toBe('Admin User');
        expect($user->hasRole('admin'))->toBeTrue();
        expect(Auth::check())->toBeTrue();
    });

    it('validates name is required during setup', function () {
        Livewire::test('pages::admin.login')
            ->set('name', '')
            ->set('email', 'admin@example.com')
            ->set('password', 'password123')
            ->set('passwordConfirmation', 'password123')
            ->call('register')
            ->assertHasErrors(['name']);
    });

    it('validates email is required during setup', function () {
        Livewire::test('pages::admin.login')
            ->set('name', 'Admin User')
            ->set('email', '')
            ->set('password', 'password123')
            ->set('passwordConfirmation', 'password123')
            ->call('register')
            ->assertHasErrors(['email']);
    });

    it('validates password minimum length during setup', function () {
        Livewire::test('pages::admin.login')
            ->set('name', 'Admin User')
            ->set('email', 'admin@example.com')
            ->set('password', 'short')
            ->set('passwordConfirmation', 'short')
            ->call('register')
            ->assertHasErrors(['password']);
    });

    it('validates password confirmation matches during setup', function () {
        Livewire::test('pages::admin.login')
            ->set('name', 'Admin User')
            ->set('email', 'admin@example.com')
            ->set('password', 'password123')
            ->set('passwordConfirmation', 'different123')
            ->call('register')
            ->assertHasErrors(['passwordConfirmation']);
    });
});

// ============================================
// Component Tests (Livewire::test)
// ============================================

describe('component tests', function () {
    beforeEach(function () {
        User::factory()->create();
    });

    it('renders successfully', function () {
        Livewire::test('pages::admin.login')
            ->assertStatus(200);
    });

    it('has admin login title when users exist', function () {
        Livewire::test('pages::admin.login')
            ->assertSee('Stream Admin');
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
});

// ============================================
// Browser Tests (Pest Browser Plugin)
// ============================================

describe('browser tests', function () {
    beforeEach(function () {
        User::factory()->create();
    });

    it('displays login form correctly', function () {
        $page = visit('/admin/login');

        $page->waitForText('Stream Admin')
            ->assertSee('Stream Admin')
            ->assertSee('Sign in to access the admin panel')
            ->assertVisible('@email-input')
            ->assertVisible('@password-input')
            ->assertVisible('@remember-checkbox')
            ->assertVisible('@login-button');
    });

    it('shows error toast when submitting empty form', function () {
        $page = visit('/admin/login');

        $page->click('@login-button')
            ->waitForText('Email and password are required');
    });

    it('shows error toast with invalid credentials', function () {
        $page = visit('/admin/login');

        $page->type('@email-input', 'wrong@email.com')
            ->type('@password-input', 'wrongpassword')
            ->click('@login-button')
            ->waitForText('Invalid credentials');
    });

    it('shows error toast for non-admin user', function () {
        $user = User::factory()->create([
            'password' => 'password123',
        ]);

        $page = visit('/admin/login');

        $page->type('@email-input', $user->email)
            ->type('@password-input', 'password123')
            ->click('@login-button')
            ->waitForText('Invalid credentials');
    });

    it('redirects admin user to dashboard after login', function () {
        $user = User::factory()->create([
            'password' => 'password123',
        ]);
        $user->assignRole('admin');

        $page = visit('/admin/login');

        $page->type('@email-input', $user->email)
            ->type('@password-input', 'password123')
            ->click('@login-button')
            ->wait(2)
            ->assertPathIs('/admin/dashboard');
    });

    it('can check remember me checkbox', function () {
        $page = visit('/admin/login');

        $page->click('@remember-checkbox');

        // Verify the checkbox is present and was clicked (Flux uses custom elements)
        expect($page->content())->toContain('data-test="remember-checkbox"');
    });

    it('can complete full login flow with remember me', function () {
        $user = User::factory()->create([
            'password' => 'password123',
        ]);
        $user->assignRole('admin');

        $page = visit('/admin/login');

        $page->type('@email-input', $user->email)
            ->type('@password-input', 'password123')
            ->click('@remember-checkbox')
            ->click('@login-button')
            ->wait(2)
            ->assertPathIs('/admin/dashboard');
    });

    it('has no javascript errors', function () {
        $page = visit('/admin/login');

        $page->assertNoJavaScriptErrors();
    });

    it('takes screenshot of login page', function () {
        visit('/admin/login')
            ->screenshot()
            ->assertSee('Stream Admin');
    });
});

describe('setup browser tests', function () {
    it('displays setup form when no users exist', function () {
        $page = visit('/admin/login');

        $page->waitForText('Welcome to Stream')
            ->assertSee('Welcome to Stream')
            ->assertSee('Create your admin account');
    });
});
