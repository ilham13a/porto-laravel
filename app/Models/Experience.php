<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;
    protected $fillable = [
        'judul_experience',
        'sub_experience',
        'description',
        'tgl_masuk',
        'tgl_keluar'
    ];
    protected $date = ['deleted_at'];
}
