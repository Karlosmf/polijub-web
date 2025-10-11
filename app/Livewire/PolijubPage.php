<?php
namespace App\Livewire;
use Livewire\Component;
/**
* PolijubPage Component
*
* Este es el componente principal de Livewire que actúa como el controlador
* para la página de la heladería Polijub. Su única responsabilidad
* es renderizar la vista principal de la página.
*/
class PolijubPage extends Component
{
/**
* Renderiza la vista del componente.
*
* @return \Illuminate\View\View
*/
public function render()
{
// Retorna la vista Blade asociada a este componente.
// Utiliza el layout 'layouts.app' como plantilla base.
return view('livewire.polijub-page')->layout('layouts.app');
}
}
