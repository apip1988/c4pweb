<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KompetensiPermohonan extends Model
{
    // Nama table yang kita migrate tadi
    protected $table = 'kompetensi_permohans';

    // Kolum yang dibenarkan untuk simpan data
    protected $fillable = [
        'user_id', 
        'status_pengesahan', 
        'status_layak', 
        'tarikh_exam', 
        'masa_exam', 
        'medium', 
        'lokasi_pautan', 
        'keputusan'
    ];

    /**
     * HUBUNGAN DENGAN TABLE USER
     * Ini fungsi 'keramat' untuk kita tarik Nama, IC, Sektor, PTJ dari table users.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}