<?php

use App\Models\User;
use App\Livewire\Admin\Themes;
use Livewire\Livewire;

test('themes page is displayed to authenticated users', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->get(route('admin.themes'));

    $response->assertOk();
    $response->assertSee('Theme Selection');
});

test('themes component renders correctly with widgets', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Themes::class)
        ->assertStatus(200)
        ->assertSee('Ventas Totales')
        ->assertSee('Nuevos Clientes')
        ->assertSee('Listado de Usuarios');
});

test('unauthenticated users cannot access themes page', function () {
    $response = $this->get(route('admin.themes'));

    $response->assertRedirect(route('login'));
});
