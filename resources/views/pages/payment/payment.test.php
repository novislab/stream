<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('payment')
        ->assertStatus(200);
});
