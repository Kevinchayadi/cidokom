<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChickenSize extends Model
{
    use HasFactory;
    protected $fillable = [
        'size',
        'harga'
    ];
    public function SaleTransactions(){
        return $this->hasMany(saleTransaction::class,'id_ayam','id');
    }
}
