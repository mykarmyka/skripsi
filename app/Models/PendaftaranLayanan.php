<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PendaftaranLayanan extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_layanan';

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien');
    }
}
