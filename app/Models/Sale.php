<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $table = 'sales';

    // Tentukan kolom yang bisa diisi (fillable)
    protected $fillable = [
        'id_pen',
        'qty',
    ];

    // Jika perlu menambahkan relasi dengan model lain, misalnya 'Pen', kamu bisa menambahkannya di sini
    public function pen()
    {
        return $this->belongsTo(Pen::class, 'id_pen');
    }
}
