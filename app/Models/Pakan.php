<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pakan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pakan',
        'qty',
        'harga'
    ];

    function daily_feed(){
        return $this->hasMany(Daily_feed::class, 'id_pakan', 'id');
    }
}
