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

    public $incrementing = true; 
    protected $keyType = 'int'; 

    protected $fillable = [
        'id_rm',
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

    protected $hidden = [
        'password',
    ];

    public function getAuthIdentifierName()
    {
        return 'id_pasien';
    }

    public function getAuthIdentifier()
    {
        return $this->id_pasien;
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($pasien) {
            if (empty($pasien->id_rm) || $pasien->id_rm === 'RM0000') {
                $pasien->id_rm = 'RM' . str_pad((string) $pasien->id_pasien, 4, '0', STR_PAD_LEFT);
                $pasien->save();
            }
        });
    }
}


