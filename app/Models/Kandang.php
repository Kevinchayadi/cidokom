<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kandang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kandang',
        'lokasi_kandang',
        'jenis_kandang'
    ];

    public function pen()
    {
        return $this->hasMany(Pen::class,'id_kandang', 'id');
    }


    
}
