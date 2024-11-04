<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pen extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_kandang',
        'code_pen'
    ];

    public function kandang(){
        return $this->belongsTo(Kandang::class, 'id_kandang', 'id');
    }
}
