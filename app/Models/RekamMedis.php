<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RekamMedis extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis';
    protected $primaryKey = 'id_rm';

    protected $fillable = [
        'id_pasien', 'id_pendaftaran', 'id_admin', 'tgl_rm',
        'anamnesa', 'diagnosa', 'terapi', 'keterangan'
    ];
    
    public function pasien() {
        return $this->belongsTo(Pasien::class, 'id_pasien');
    }

    public function admin() {
        return $this->belongsTo(Admin::class, 'id_admin');
    }

    public function pendaftaran() {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran');
    }

    public function layanan()
    {
        return $this->belongsTo(PendaftaranLayanan::class);
    }
}
