<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\JenisLayanan;

class PendaftaranLayanan extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_layanan';

    protected $primaryKey = 'id_pendaftaran';
    public $incrementing = true; 
    protected $keyType = 'int';   

    protected $fillable = [
    'id_pasien',
    'tgl_pendaftaran',
    'id_jenis_layanan',
    'no_antrian',
    'status'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id_pasien');
    }

    public function jenisLayanan()
    {
        return $this->belongsTo(JenisLayanan::class, 'id_jenis_layanan');
    }

    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class, 'id_pendaftaran', 'id_pendaftaran');
    }

    public static function hitungEstimasiDatang($layananId, $noAntrian)
    {
    $jamBuka = now()->setTime(7, 0, 0); // jam buka klinik 07:00 WIB

    // ambil semua pasien sebelumnya
    $pendaftaranSebelumnya = self::where('no_antrian', '<', $noAntrian)
        ->orderBy('no_antrian', 'asc')
        ->get();

    $totalMenit = 0;

    foreach ($pendaftaranSebelumnya as $p) {
        $layanan = JenisLayanan::find($p->id_jenis_layanan);
        $totalMenit += $layanan ? $layanan->durasi : 0;
    }

    $estimasi = $jamBuka->copy()->addMinutes($totalMenit);

    return $estimasi->format('H:i');
    }

    
}
