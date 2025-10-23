<?php

namespace App\Livewire\Layout;

use Livewire\Component as LivewireComponent;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Log;

class Navigation extends LivewireComponent
{
    public function logout(Logout $logout): void
    {
        Log::info('Logout method called in Navigation component.');
        $logout();

        $this->redirect('/', navigate: true);
    }

    public function render()
    {
        return view('livewire.layout.navigation');
    }
}
