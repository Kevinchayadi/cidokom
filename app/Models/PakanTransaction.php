<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PakanTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_pakan',
        'first_stock',
        'qty',
        'harga_pembelian'
    ];
}
