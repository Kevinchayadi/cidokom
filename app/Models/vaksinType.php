<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vaksinType extends Model
{
    use HasFactory;
    protected $table = 'vaksin_types';
    protected $fillable = [
        'nama_vaksin',
        'qty',
        'harga'
    ];
}
