<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PendaftaranLayanan extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_layanan';

    protected $fillable = [
    'id_pendaftaran',
    'id_pasien',
    'tgl_pendaftaran',
    'jenis_layanan',
    'no_antrian',
    'status'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien');
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }
}
