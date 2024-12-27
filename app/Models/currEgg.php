<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class currEgg extends Model
{
    use HasFactory;
    protected $table = 'curr_eggs';

    // Tentukan kolom yang dapat diisi (fillable)
    protected $fillable = [
        'id_pen',
        'qty',
        'cost_egg',
    ];
}
