<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $guard_name = 'admin';
    protected $guard = 'admin';
    protected $table = 'admin'; 
    protected $primaryKey = 'id_admin'; 
    public $incrementing = true; 
    protected $keyType = 'int';

    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
