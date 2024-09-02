<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'picture',
        'nama_lengkap',
        'no_telepon',
        'email',
        'description',
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'alamat',
        'status'
    ];
    protected $date = ['deleted_at'];
}
