<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

class Contact extends Component
{
    use Toast, WithFileUploads;

    public string $cv_name = '';
    public string $cv_email = '';
    public $cv_file;

    #[Layout('layouts.frontend')]
    public function render()
    {
        return view('livewire.contact');
    }

    public function sendCV()
    {
        $this->validate([
            'cv_name' => 'required|min:3',
            'cv_email' => 'required|email',
            'cv_file' => 'required|mimes:pdf|max:2048',
        ]);

        // Logic to save/send CV would go here
        
        $this->success('CV enviado correctamente. ¡Gracias por querer sumarte!');
        $this->reset(['cv_name', 'cv_email', 'cv_file']);
    }

    public function requestFranchise()
    {
        // For now, just a placeholder action
        $this->info('Estamos procesando tu solicitud de franquicia. Nos pondremos en contacto pronto.');
    }
}
