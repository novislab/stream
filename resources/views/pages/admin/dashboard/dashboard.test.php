<?php

use Livewire\Livewire;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::findOrCreate('admin');
});

describe('component tests', function () {
    it('renders successfully', function () {
        Livewire::test('pages::admin.dashboard')
            ->assertStatus(200);
    });
});
