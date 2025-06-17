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
        'Helm Safety',
        'Pelindung Mata',
        'Masker',
        'Pelindung Telinga',
        'Sarung Tangan',
        'Rompi Safety',
        'Sepatu Safety'
    ];
    public $checked = [];
    public $photo;
    public $photoPreviewUrl = null;
    public $sudahChecklist;
    public $sesi;

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

    public function save($base64Image)
    {
        $now = Carbon::now('Asia/Jakarta');
        $tanggal = $now->format('Y-m-d');
        $jam = $now->format('H:i:s');
        // Hilangkan header "data:image/png;base64,"
        $image = str_replace('data:image/png;base64,', '', $base64Image);
        $image = str_replace(' ', '+', $image);
        $filename = 'foto_checklist_' . auth()->id() . '_' . time() . '.png';
        $path = "checklist_photos/" . $filename;

        Storage::disk('public')->put("checklist_photos/{$filename}", base64_decode($image));

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
        $jam = $now->format('H:i:s');
        $this->sesi = strtotime($jam) > strtotime("12:00:00") ? 2 : 1;
        if ($this->sesi == 1) {
            $this->sudahChecklist = ChecklistUser::where('user', auth()->id())
                ->where('tanggal', $tanggal)
                ->whereBetween('jam', ['06:00:00', '12:00:00'])
                ->exists();
        }else{
            $this->sudahChecklist = ChecklistUser::where('user', auth()->id())
                ->where('tanggal', $tanggal)
                ->whereBetween('jam', ['12:00:01', '18:00:00'])
                ->exists();
        }
    }
    public function render()
    {
        return view('livewire.apc-checklist');
    }
}
