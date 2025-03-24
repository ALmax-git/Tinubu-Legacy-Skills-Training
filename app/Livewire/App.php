<?php

namespace App\Livewire;

use Livewire\Component;

class App extends Component
{
    public $tab = 'Dashboard';

    public function toggle_tab($tab)
    {
        $this->tab = $tab;
    }
    public function mount()
    {
        $this->tab = 'Dashboard';
    }
    public function render()
    {
        return view('livewire.app');
    }
}
