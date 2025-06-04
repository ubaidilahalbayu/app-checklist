<?php

namespace App\Livewire;

use Livewire\Component;

class TestCheckbox extends Component
{
    public $checked = [];

    public function processMa()
    {
        // if ($this->checked) {
        //     array_push($this->checked, $this->checked);
        // }
    }
    
    public function render()
    {
        return view('livewire.test-checkbox')->layout('layouts.app');
    }
}
