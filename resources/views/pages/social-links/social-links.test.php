<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('social-links')
        ->assertStatus(200);
});
