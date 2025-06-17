<?php

namespace App\Livewire;

use App\Exports\ChecklistExport;
use App\Models\ChecklistUser;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Riwayat extends Component
{
    public $isAdmin;
    public $start;
    public $end;
    public function export()
    {
        if ($this->isAdmin === 1) {
            return Excel::download(new ChecklistExport($this->start, $this->end), 'checklist.xlsx');
        }
        return;
    }
    public function mount()
    {
        $now = Carbon::now('Asia/Jakarta');
        $tanggal = $now->format('Y-m-d');
        $this->start = date($tanggal);
        $this->end = date($tanggal);
        $this->isAdmin = auth()->id();
        $this->isAdmin = User::where('id', $this->isAdmin)->first()->level;
    }
    public function render()
    {
        $now = Carbon::now('Asia/Jakarta');
        $tanggal = $now->format('Y-m-d');

        $dataBerlangsung = User::select(['users.id', 'users.name', 'users.email', 'checklist_user.*', DB::raw("CASE WHEN checklist_user.tanggal IS NOT NULL THEN 1  ELSE 0 END AS sudah"), DB::raw("'".Storage::url('')."' || checklist_user.photo AS photo_url")])
        ->leftJoin('checklist_user', function ($join) use ($tanggal) {
            $join->on('checklist_user.user', '=', 'users.id')
                ->where('checklist_user.tanggal', '=', $tanggal);
        })->where('users.id', auth()->id())->orderBy('users.name')->paginate(10);

        $dataSelesai = ChecklistUser::select(['checklist_user.*', 'users.id', 'users.name', 'users.email'])->join('users', 'users.id', '=', 'checklist_user.user')->orderBy('checklist_user.tanggal', 'desc')->orderBy('checklist_user.jam', 'asc')->where('users.id', auth()->id())->paginate(10);
        if ($this->isAdmin === 1) {
            $dataBerlangsung = User::select(['users.id', 'users.name', 'users.email', 'checklist_user.*', DB::raw("CASE WHEN checklist_user.tanggal IS NOT NULL THEN 1 ELSE 0 END AS sudah"), DB::raw("'".Storage::url('')."' || checklist_user.photo AS photo_url")])
            ->leftJoin('checklist_user', function ($join) use ($tanggal) {
                $join->on('checklist_user.user', '=', 'users.id')
                    ->where('checklist_user.tanggal', '=', $tanggal);
            })->orderBy('users.name')->paginate(10);
    
            $dataSelesai = ChecklistUser::select(['checklist_user.*', 'users.id', 'users.name', 'users.email'])->join('users', 'users.id', '=', 'checklist_user.user')->orderBy('checklist_user.tanggal', 'desc')->orderBy('checklist_user.jam', 'asc')->paginate(10);
        }
        $data = [
        'dataBerlangsung' => $dataBerlangsung,
        'dataSelesai' => $dataSelesai,
        ];
            
        // dd($data);
        return view('livewire.riwayat', $data);
    }
}
