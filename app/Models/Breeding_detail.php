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
        'feed',
        'feed_name',
        'id_admin'
    ];

    public function breeding()
    {
        return $this->belongsTo(Breeding::class, 'id_breeding', 'id');
    }
    
}
