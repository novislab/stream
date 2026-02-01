<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('home')
        ->assertStatus(200);
});
