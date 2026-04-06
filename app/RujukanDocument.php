<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RujukanDocument extends Model
{
    // Ini adalah kunci untuk membenarkan semua kolum diisi (Mass Assignment)
    protected $guarded = []; 

    // ATAU Afif boleh senaraikan satu-persatu (Fillable)
    // protected $fillable = ['type', 'title', 'publisher', 'year', 'file_path'];
}