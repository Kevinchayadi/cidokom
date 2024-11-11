<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hatchery_detail extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_hatchery',
        'total_setting',
        'infertile',
        'exploid',
        'explode',
        'hatcher',
        'dead_in_egg',
        'hatchability',
        'doc_afkir',
        'saleable',
        'inputBy'
    ];

    public function hatchery(){
        return $this->belongsTo(Hatchery::class, 'id_hatchery', 'id_hatchery');
    }
}
