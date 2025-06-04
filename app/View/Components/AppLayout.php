<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function mount()
    {
        if (!auth()->check()) {
            session()->flash('error', 'Anda harus login untuk mengakses halaman ini.');
            return redirect()->route('login');
        }
    }
    public function render(): View
    {
        return view('layouts.app');
    }
}
