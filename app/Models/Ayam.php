<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ayam extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_ayam',
        'strain_male',
        'strain_female',
    ];

}
