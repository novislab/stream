<?php

use App\Models\Payment;
use App\Models\User;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::findOrCreate('admin');
    $this->user = User::factory()->create();
    $this->user->assignRole('admin');
});

test('payments page displays total payments', function () {
    Payment::factory()->count(5)->create(['status' => 'completed']);

    $response = $this->actingAs($this->user)->get('/admin/payments');

    $response->assertStatus(200);
});

test('payments page shows payment stats', function () {
    Payment::factory()->count(3)->create(['status' => 'completed']);
    Payment::factory()->count(2)->create(['status' => 'pending']);

    $response = $this->actingAs($this->user)->get('/admin/payments');

    $response->assertStatus(200);
    expect($response->getContent())->toContain('Total Payments');
});

test('payment model casts status correctly', function () {
    $payment = Payment::factory()->create(['status' => 'completed']);

    expect($payment->status)->toBe('completed');
});
