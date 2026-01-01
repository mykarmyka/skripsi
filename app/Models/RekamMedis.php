<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\PendaftaranLayanan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class RekamMedis extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis';
    
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_rm',
        'id_pasien', 
        'id_pendaftaran', 
        'id_admin',
        'id_jenis_layanan',
        'tgl_rm',
        'anamnesa', 
        'diagnosa', 
        'terapi', 
        'keterangan'
    ];
    
    public function pasien() {
        return $this->belongsTo(Pasien::class, 'id_pasien');
    }

    public function admin() {
        return $this->belongsTo(Admin::class, 'id_admin');
    }

    public function pendaftaran() {
        return $this->belongsTo(PendaftaranLayanan::class, 'id_pendaftaran', 'id_pendaftaran');
    }

    public function jenisLayanan()
    {
        return $this->belongsTo(JenisLayanan::class, 'id_jenis_layanan', 'id');
    }

}
