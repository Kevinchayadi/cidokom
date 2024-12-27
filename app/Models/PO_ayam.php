<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PO_ayam extends Model
{
    use HasFactory;

    protected $table = 'p_o_ayams';

    // Tentukan kolom yang bisa diisi (fillable)
    protected $fillable = [
        'jumlah_ayam',
        'nama_pembeli',
        'total_harga',
        'description',
    ];
}
