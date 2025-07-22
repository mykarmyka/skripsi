<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pasien extends Authenticatable
{
    use Notifiable;

    protected $table = 'pasien';

    protected $primaryKey = 'id_pasien';

    protected $fillable = [
        'nama', 
        'nik',
        'tempat_lahir',
        'tgl_lahir', 
        'jenis_kelamin',
        'alamat',
        'no_telp', 
        'nama_pasangan', 
        'email',
    ];
}


