<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhcalsResult extends Model
{
    // Ini adalah 'kunci' untuk benarkan data masuk ke table
    protected $fillable = [
        'user_id',
        'set_number',
        'score',
        'correct_count',
        'start_time',
        'end_time'
    ];

    /**
     * Hubungkan dengan User (Optional tapi bagus untuk ada)
     */
   public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }
}