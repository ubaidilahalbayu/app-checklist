<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ChecklistUser;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class ApcChecklist extends Component
{
    use WithFileUploads;
    public $items = [
        'Helem Safety',
        'Pelindung Mata',
        'Masker',
        'Pelindung Telinga',
        'Sarung Tangan',
        'Rompi Keselamatan',
        'Sepatu Safety'
    ];
    public $checked = [];
    public $photo;
    public $photoPreviewUrl = null;
    public $sudahChecklist;

    public function proses()
    {
        
    }
    
    public function backChecklist()
    {
        $this->reset(['photo', 'photoPreviewUrl']);
        
    }

    public function updatedPhoto()
    {
        $this->photoPreviewUrl = $this->photo->temporaryUrl();
    }

    public function save()
    {
        $now = Carbon::now('Asia/Jakarta');
        $tanggal = $now->format('Y-m-d');
        $jam = $now->format('H:i:s');
        $path = $this->photo->store('checklist_photos', 'public');

        try{
            ChecklistUser::create([
                'user' => auth()->id(),
                'tanggal' => $tanggal,
                'jam' => $jam,
                'checklist' => json_encode($this->checked),
                'photo' => $path,
            ]);
        }catch(Exception $e){
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            session()->flash('error', $e->getMessage());
            return;
        }

        $this->reset(['checked', 'photo', 'photoPreviewUrl']);
        session()->flash('success', 'Checklist berhasil disimpan!');
        $this->sudahChecklist = true;
    }
    public function mount()
    {
        $now = Carbon::now('Asia/Jakarta');
        $tanggal = $now->format('Y-m-d');
        $this->sudahChecklist = ChecklistUser::where('user', auth()->id())
            ->where('tanggal', $tanggal)
            ->exists();
    }
    public function render()
    {
        return view('livewire.apc-checklist');
    }
}
