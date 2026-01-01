<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisLayanan extends Model
{
    use HasFactory;

    protected $table = 'jenis_layanan';

    protected $fillable = [
        'id',
        'nama_layanan',
        'durasi',
    ];

    public function pendaftaran()
    {
        return $this->hasMany(PendaftaranLayanan::class, 'id_jenis_layanan');
    }

    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class, 'id_jenis_layanan', 'id');
    }

}
