<?php
namespace App\Livewire;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
/**
* PolijubPage Component
*
* Este es el componente principal de Livewire que actúa como el controlador
* para la página de la heladería Polijub. Su única responsabilidad
* es renderizar la vista principal de la página.
*/
#[Layout('layouts.frontend')]
class Landing extends Component
{
/**
* Renderiza la vista del componente.
*
* @return mixed
*/
public function render(): mixed
{
// Retorna la vista Blade asociada a este componente.
// Utiliza el layout 'layouts.app' como plantilla base.
return view('livewire.landing');
}
}
