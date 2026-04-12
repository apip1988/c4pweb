<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rujukan extends Model
{
    // Nama table dalam database
    protected $table = 'rujukans';

    // Kolum yang dibenarkan untuk simpan data
    protected $fillable = [
        'type', 
        'title', 
        'publisher', 
        'year', 
        'file_path'
    ];
}