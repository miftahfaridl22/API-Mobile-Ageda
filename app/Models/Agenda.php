<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_agenda',
        'nama_agenda',
        'waktu_agenda',
        'tempat_agenda',
        'disposisi_agenda'
    ];
}
