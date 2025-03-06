<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table_move extends Model
{
    use HasFactory;

    protected $fillable = [
        'current_pen',
        'destination_pen',
        'totalMale',
        'totalFemale',
        'maleCost',
        'femaleCost',
        'status',
    ];
}
