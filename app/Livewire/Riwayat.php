<?php

namespace App\Livewire;

use App\Models\ChecklistUser;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Riwayat extends Component
{
    public function render()
    {
        $now = Carbon::now('Asia/Jakarta');
        $tanggal = $now->format('Y-m-d');
        $dataBerlangsung = User::select(['users.id', 'users.name', 'users.email', 'checklist_user.*', DB::raw("IF(checklist_user.tanggal IS NOT NULL, 1, 0) AS sudah"), DB::raw("CONCAT('".Storage::url('')."', checklist_user.photo) AS photo_url")])->leftJoin('checklist_user', 'checklist_user.user', '=', 'users.id')->orderBy('users.name')->paginate(10);

        $dataSelesai = ChecklistUser::select(['checklist_user.*', 'users.id', 'users.name', 'users.email'])->join('users', 'users.id', '=', 'checklist_user.user')->orderBy('checklist_user.tanggal', 'desc')->orderBy('checklist_user.jam', 'asc')->paginate(10);
        $data = [
            'dataBerlangsung' => $dataBerlangsung,
            'dataSelesai' => $dataSelesai,
        ];
        // dd($data);
        return view('livewire.riwayat', $data);
    }
}
