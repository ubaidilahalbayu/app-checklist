<?php

namespace App\Exports;

use App\Models\ChecklistUser;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ChecklistExport implements FromCollection, WithHeadings, WithDrawings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $start, $end;

    public function __construct($start, $end) {
        $this->start = $start;
        $this->end = $end;
    }

    public function collection()
    {
        return ChecklistUser::select(['users.name', 'users.email', 'checklist_user.tanggal', 'checklist_user.jam', 'checklist_user.checklist'])->join('users', 'users.id', '=', 'checklist_user.user')->whereBetween('checklist_user.tanggal', [$this->start, $this->end])->orderBy('checklist_user.tanggal', 'desc')->orderBy('checklist_user.jam', 'asc')->get();
    }
    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Tanggal',
            'Jam',
            'Checklist',
            'Photo',
        ];
    }
    public function drawings()
    {
        $checklist = ChecklistUser::select(['users.name', 'users.email', 'checklist_user.photo'])->join('users', 'users.id', '=', 'checklist_user.user')->whereBetween('checklist_user.tanggal', [$this->start, $this->end])->orderBy('checklist_user.tanggal', 'desc')->orderBy('checklist_user.jam', 'asc')->get();
        $drawings = [];

        foreach ($checklist as $index => $ck) {
            if (!$ck->photo || !file_exists(public_path('storage/'.$ck->photo))) {
                continue;
            }

            $drawing = new Drawing();
            $drawing->setName($ck->name);
            $drawing->setDescription('APD Photo');
            $drawing->setPath(public_path('storage/'.$ck->photo));
            $drawing->setHeight(50);
            $drawing->setCoordinates('F' . ($index + 2)); // C2, C3, dst. karena header ada di baris 1
            $drawings[] = $drawing;
        }

        return $drawings;
    }
}
