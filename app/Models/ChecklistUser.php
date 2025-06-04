<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class ChecklistUser extends Model
{
    protected $table = 'checklist_user';
    protected $fillable = [
        'user',
        'tanggal',
        'jam',
        'checklist',
        'photo',
    ];

    public function getTanggalIndoAttribute()
    {
        setlocale(LC_TIME, 'id_ID.utf8');
        Carbon::setLocale('id');
        return Carbon::parse($this->tanggal)->translatedFormat('l, d F Y');
    }

    public function getPhotoUrlAttribute()
    {
        return Storage::url($this->photo);
    }

    public function getChecklistArrayAttribute()
    {
        return $this->checklist
            ? json_decode($this->checklist, true) ?? []
            : [];
    }
}
