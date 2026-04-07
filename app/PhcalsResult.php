<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhcalsResult extends Model
{
    // Kolum yang dibenarkan untuk disimpan (mesti sama dengan migration)
    protected $fillable = [
        'user_id', 
        'set_id', 
        'score', 
        'status', 
        'review_data', 
        'attempt_date', 
        'expiry_date'
    ];

    // Hubungan: Satu keputusan milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}