<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; 
use Spatie\Permission\Models\Role;


class Admin extends Authenticatable 
{
    use HasFactory, Notifiable, HasRoles; 

    protected $table = 'admin'; 
    protected $primaryKey = 'id_admin';
    protected $guard_name = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', 
    ];

    // Relasi ke RekamMedis
    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class, 'id_admin', 'id_admin');
    }


}