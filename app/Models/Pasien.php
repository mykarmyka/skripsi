<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';

    protected $fillable = [
        'nama', 
        'tempat_lahir',
        'tanggal_lahir', 
        'jenis_kelamin',
        'alamat',
        'no_telp', 
        'nama_pasangan', 
        'NIK',
        'email',
    ];
}
