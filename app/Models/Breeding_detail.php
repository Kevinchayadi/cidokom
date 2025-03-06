<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breeding_detail extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_breeding',
        'last_female',
        'last_male',
        'female_die',
        'female_reject',
        'male_die',
        'male_reject',
        'egg_morning',
        'egg_afternoon',
        'broken',
        'abnormal',
        'sale',
        'total_egg',
        'move_to',
        'total_male_move',
        'total_female_move',
        'receive_from',
        'total_male_receive',
        'total_female_receive',
        'cost_unit',
        'cost_total',
        'feed',
        'feed_name',
        'status',
        'inputBy',
        'created_at',
    ];

    public function breeding()
    {
        return $this->belongsTo(Breeding::class, 'id_breeding', 'id');
    }
    
}
