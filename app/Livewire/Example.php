<?php

namespace App\Livewire;

use Livewire\Component;

class Example extends Component
{
    public $title = "My example";

    public function render()
    {
        return view('livewire.example');
    }
}
