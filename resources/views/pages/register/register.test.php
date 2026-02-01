<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('register')
        ->assertStatus(200);
});
