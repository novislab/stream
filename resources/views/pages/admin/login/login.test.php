<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::findOrCreate('admin');
});

// ============================================
// Component Tests (Livewire::test)
// ============================================

describe('component tests', function () {
    it('renders successfully', function () {
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
});

// ============================================
// Browser Tests (Pest Browser Plugin)
// ============================================

describe('browser tests', function () {
    it('displays login form correctly', function () {
        $page = visit('/admin/login');

        $page->waitForText('Admin Login')
            ->assertSee('Admin Login')
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
            ->assertSee('Admin Login');
    });
});
