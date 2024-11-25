<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Afkir extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_pen',
        'male',
        'female',
        'male_cost',
        'female_cost',
        'feed_male',
        'feed_female',
        'male_come',
        'female_come',
        'male_out',
        'female_out',
    ];
}
