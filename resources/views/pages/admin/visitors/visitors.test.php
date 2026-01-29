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

it('renders successfully', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    Livewire::actingAs($user)
        ->test('pages::admin.visitors')
        ->assertStatus(200);
});

it('loads visitors on mount', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    // Create some visits
    Visit::create(['ip' => '192.168.1.1', 'url' => '/', 'method' => 'GET']);
    Visit::create(['ip' => '192.168.1.2', 'url' => '/about', 'method' => 'GET']);

    Livewire::actingAs($user)
        ->test('pages::admin.visitors')
        ->assertSet('hasMore', false) // Less than 20 visits
        ->assertViewHas('visitors');
});

it('can load more visitors', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    Livewire::actingAs($user)
        ->test('pages::admin.visitors')
        ->call('loadMore')
        ->assertStatus(200);
});

it('shows breadcrumbs', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    Livewire::actingAs($user)
        ->test('pages::admin.visitors')
        ->assertSee('Visitors');
});

it('shows table headers', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    Livewire::actingAs($user)
        ->test('pages::admin.visitors')
        ->assertSee('Page')
        ->assertSee('Visited');
});
