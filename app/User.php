<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Nama kolom yang DIBENARKAN untuk disimpan (Mass Assignment)
     */
    protected $fillable = [
    'name', 
    'email', 
    'password', 
    'ic_number', 
    'phone_number', 
    'no_lpp', 
    'sektor', 
    'ptj_sekarang', 
    'tarikh_lantikan',
    'edu_diploma'
];

    protected $hidden = [
        'password', 'remember_token',
    ];
}