<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Literation extends Model
{
    use HasFactory;

    protected $table = 'literations';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'nik');
    }
}
