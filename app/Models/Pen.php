<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pen extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_kandang',
        'code_pen',
        'total_egg',
        'total_cost'
    ];

    public function kandang(){
        return $this->belongsTo(Kandang::class, 'id_kandang', 'id');
    }
    public function breeding(){
        return $this->hasMany(Breeding::class, 'id_pen', 'id');
    }
    
    public function commercial(){
        return $this->hasMany(Commercial::class, 'id_pen', 'id');
    }
}
