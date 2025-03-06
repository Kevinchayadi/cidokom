<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class saleTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal_Penjualan',
        'id_pembeli',
        'jumlah_ayam',
        'id_ayam',
        'harga',
        'total_harga',
        'status',
        'description'
    ];

    public function Customers(){
        return $this->belongsTo(Customer::class, 'id_pembeli', 'id');
    }
    public function ChickenSize(){
        return $this->belongsTo(ChickenSize::class, 'id_ayam', 'id');
    }
}
