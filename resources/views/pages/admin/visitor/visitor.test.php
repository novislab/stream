<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('admin.visitor')
        ->assertStatus(200);
});
