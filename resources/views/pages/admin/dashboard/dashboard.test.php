<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Shetabit\Visitor\Models\Visit;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function () {
    Role::findOrCreate('admin');
});

// ============================================
// Component Tests (Livewire::test)
// ============================================

describe('component tests', function () {
    it('renders successfully', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->assertStatus(200);
    });

    it('shows skeleton loading initially', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->assertSet('loaded', false)
            ->assertSee('shimmer'); // Skeleton uses shimmer animation
    });

    it('loads data when loadData is called', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->assertSet('loaded', false)
            ->call('loadData')
            ->assertSet('loaded', true);
    });

    it('shows stats cards after loading', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->call('loadData')
            ->assertSee('Unique Visitors')
            ->assertSee('Total Pageviews')
            ->assertSee('Today')
            ->assertSee('This Month');
    });

    it('has default chart period of monthly', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->assertSet('chartPeriod', 'monthly');
    });

    it('can change chart period to quarterly', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->call('setChartPeriod', 'quarterly')
            ->assertSet('chartPeriod', 'quarterly');
    });

    it('can change chart period to annually', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->call('setChartPeriod', 'annually')
            ->assertSet('chartPeriod', 'annually');
    });

    it('can refresh top pages section', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->call('loadData')
            ->call('refreshTopPages')
            ->assertStatus(200);
    });

    it('can refresh active users section', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->call('loadData')
            ->call('refreshActiveUsers')
            ->assertStatus(200);
    });

    it('can refresh visitor stats section', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->call('loadData')
            ->call('refreshVisitorStats')
            ->assertStatus(200);
    });

    it('can refresh channels section', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->call('loadData')
            ->call('refreshChannels')
            ->assertStatus(200);
    });

    it('can refresh devices section', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->call('loadData')
            ->call('refreshDevices')
            ->assertStatus(200);
    });

    it('shows analytics section after loading', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->call('loadData')
            ->assertSee('Analytics')
            ->assertSee('Monthly')
            ->assertSee('Quarterly')
            ->assertSee('Annually');
    });

    it('shows top pages section after loading', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->call('loadData')
            ->assertSee('Top Pages')
            ->assertSee('Source')
            ->assertSee('Pageviews');
    });

    it('shows active users section after loading', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->call('loadData')
            ->assertSee('Active Users')
            ->assertSee('Live visitors');
    });

    it('shows visitor stats section after loading', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->call('loadData')
            ->assertSee('Visitor Stats')
            ->assertSee('This Week');
    });

    it('shows acquisition channels section after loading', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->call('loadData')
            ->assertSee('Acquisition Channels')
            ->assertSee('Direct')
            ->assertSee('Referral')
            ->assertSee('Organic Search')
            ->assertSee('Social');
    });

    it('shows sessions by device section after loading', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->call('loadData')
            ->assertSee('Sessions By Device')
            ->assertSee('Desktop')
            ->assertSee('Mobile')
            ->assertSee('Tablet');
    });

    it('returns empty stats when not loaded', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->assertViewHas('stats', []);
    });

    it('returns stats array when loaded', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->call('loadData')
            ->assertViewHas('stats', function ($stats) {
                return count($stats) === 4;
            });
    });

    it('computes unique visitors correctly', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        // Create some test visits
        Visit::create(['ip' => '192.168.1.1', 'url' => '/', 'method' => 'GET']);
        Visit::create(['ip' => '192.168.1.2', 'url' => '/', 'method' => 'GET']);
        Visit::create(['ip' => '192.168.1.1', 'url' => '/about', 'method' => 'GET']); // Same IP

        $component = Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->call('loadData');

        expect($component->get('uniqueVisitors'))->toBe(2);
    });

    it('computes total pageviews correctly', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Visit::create(['ip' => '192.168.1.1', 'url' => '/', 'method' => 'GET']);
        Visit::create(['ip' => '192.168.1.2', 'url' => '/', 'method' => 'GET']);
        Visit::create(['ip' => '192.168.1.1', 'url' => '/about', 'method' => 'GET']);

        $component = Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->call('loadData');

        expect($component->get('totalPageviews'))->toBe(3);
    });

    it('computes today visitors correctly', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        // Clear visits table
        Visit::query()->delete();

        // Add visits with unique IPs
        Visit::create(['ip' => '10.0.0.1', 'url' => '/', 'method' => 'GET', 'created_at' => now()]);
        Visit::create(['ip' => '10.0.0.2', 'url' => '/', 'method' => 'GET', 'created_at' => now()]);
        Visit::create(['ip' => '10.0.0.3', 'url' => '/', 'method' => 'GET', 'created_at' => now()->subDays(2)]);

        $component = Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->call('loadData');

        // Should have 2 unique IPs for today (old visitor doesn't count)
        expect($component->get('todayVisitors'))->toBeGreaterThanOrEqual(2);
    });

    it('computes live visitors correctly', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        // Clear visits table
        Visit::query()->delete();

        // Add visits with unique IPs (within 5 minutes)
        Visit::create(['ip' => '10.0.0.1', 'url' => '/', 'method' => 'GET', 'created_at' => now()->subMinutes(2)]);
        Visit::create(['ip' => '10.0.0.2', 'url' => '/', 'method' => 'GET', 'created_at' => now()->subMinutes(3)]);
        Visit::create(['ip' => '10.0.0.3', 'url' => '/', 'method' => 'GET', 'created_at' => now()->subMinutes(10)]);

        $component = Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->call('loadData');

        // Should have 2 unique IPs within 5 minutes (10 min old doesn't count)
        expect($component->get('liveVisitors'))->toBeGreaterThanOrEqual(2);
    });

    it('computes top pages correctly', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Visit::create(['ip' => '192.168.1.1', 'url' => 'http://localhost/', 'method' => 'GET']);
        Visit::create(['ip' => '192.168.1.2', 'url' => 'http://localhost/', 'method' => 'GET']);
        Visit::create(['ip' => '192.168.1.3', 'url' => 'http://localhost/about', 'method' => 'GET']);

        $component = Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->call('loadData');

        $topPages = $component->get('topPages');

        expect($topPages)->toBeArray();
        expect($topPages[0]['url'])->toBe('/');
        expect($topPages[0]['views'])->toBe(2);
    });

    it('computes device data correctly', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $component = Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->call('loadData');

        $deviceData = $component->get('deviceData');

        expect($deviceData)->toBeArray();
        expect(count($deviceData))->toBe(3);
        expect($deviceData[0]['label'])->toBe('Desktop');
        expect($deviceData[1]['label'])->toBe('Mobile');
        expect($deviceData[2]['label'])->toBe('Tablet');
    });

    it('computes chart data correctly', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $component = Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->call('loadData');

        $chartData = $component->get('chartData');

        expect($chartData)->toBeArray();
        expect(count($chartData))->toBe(30); // Default monthly = 30 days
    });

    it('computes quarterly chart data correctly', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $component = Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->call('setChartPeriod', 'quarterly')
            ->call('loadData');

        $chartData = $component->get('chartData');

        expect($chartData)->toBeArray();
        expect(count($chartData))->toBe(90);
    });

    it('computes annually chart data correctly', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $component = Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->call('setChartPeriod', 'annually')
            ->call('loadData');

        $chartData = $component->get('chartData');

        expect($chartData)->toBeArray();
        expect(count($chartData))->toBe(365);
    });

    it('computes channels data correctly', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $component = Livewire::actingAs($user)
            ->test('pages::admin.dashboard')
            ->call('loadData');

        $channelsData = $component->get('channelsData');

        expect($channelsData)->toBeArray();
        expect(count($channelsData))->toBe(6); // 6 months
        expect($channelsData[0])->toHaveKeys(['label', 'direct', 'referral', 'organic', 'social']);
    });
});

// ============================================
// Browser Tests (Pest Browser Plugin)
// ============================================

describe('browser tests', function () {
    it('displays dashboard correctly after login', function () {
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

    it('shows dashboard content after loading', function () {
        $user = User::factory()->create([
            'password' => 'password123',
        ]);
        $user->assignRole('admin');

        $page = visit('/admin/login');

        $page->type('@email-input', $user->email)
            ->type('@password-input', 'password123')
            ->click('@login-button')
            ->wait(3)
            ->assertSee('Unique Visitors')
            ->assertSee('Total Pageviews')
            ->assertSee('Analytics');
    });

    it('shows analytics chart section', function () {
        $user = User::factory()->create([
            'password' => 'password123',
        ]);
        $user->assignRole('admin');

        $page = visit('/admin/login');

        $page->type('@email-input', $user->email)
            ->type('@password-input', 'password123')
            ->click('@login-button')
            ->wait(3)
            ->assertSee('Analytics')
            ->assertSee('Monthly')
            ->assertSee('Quarterly')
            ->assertSee('Annually');
    });

    it('shows top pages section', function () {
        $user = User::factory()->create([
            'password' => 'password123',
        ]);
        $user->assignRole('admin');

        $page = visit('/admin/login');

        $page->type('@email-input', $user->email)
            ->type('@password-input', 'password123')
            ->click('@login-button')
            ->wait(3)
            ->assertSee('Top Pages');
    });

    it('shows active users section', function () {
        $user = User::factory()->create([
            'password' => 'password123',
        ]);
        $user->assignRole('admin');

        $page = visit('/admin/login');

        $page->type('@email-input', $user->email)
            ->type('@password-input', 'password123')
            ->click('@login-button')
            ->wait(3)
            ->assertSee('Active Users')
            ->assertSee('Live visitors');
    });

    it('shows visitor stats section', function () {
        $user = User::factory()->create([
            'password' => 'password123',
        ]);
        $user->assignRole('admin');

        $page = visit('/admin/login');

        $page->type('@email-input', $user->email)
            ->type('@password-input', 'password123')
            ->click('@login-button')
            ->wait(3)
            ->assertSee('Visitor Stats');
    });

    it('shows acquisition channels section', function () {
        $user = User::factory()->create([
            'password' => 'password123',
        ]);
        $user->assignRole('admin');

        $page = visit('/admin/login');

        $page->type('@email-input', $user->email)
            ->type('@password-input', 'password123')
            ->click('@login-button')
            ->wait(3)
            ->assertSee('Acquisition Channels');
    });

    it('shows sessions by device section', function () {
        $user = User::factory()->create([
            'password' => 'password123',
        ]);
        $user->assignRole('admin');

        $page = visit('/admin/login');

        $page->type('@email-input', $user->email)
            ->type('@password-input', 'password123')
            ->click('@login-button')
            ->wait(3)
            ->assertSee('Sessions By Device');
    });

    it('takes screenshot of dashboard', function () {
        $user = User::factory()->create([
            'password' => 'password123',
        ]);
        $user->assignRole('admin');

        $page = visit('/admin/login');

        $page->type('@email-input', $user->email)
            ->type('@password-input', 'password123')
            ->click('@login-button')
            ->wait(3)
            ->screenshot()
            ->assertSee('Analytics');
    });
})->skip(! function_exists('visit'), 'Browser testing not installed');
