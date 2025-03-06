<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable=[
        'nama_pelanggan',
        'alamat_pelanggan',
        'no_telepon_pelanggan',
        'id_sales',
        'id_residence',
        'status'
    ];
    
    public function salesTransaction(){
        return $this->hasMany(saleTransaction::class, 'id_pembeli', 'id');
    }

    public function sales(){
        return $this->belongsTo(CustHandle::class, 'id_sales','id');
    }
    public function Residence(){
        return $this-> belongsTo(Resident::class, 'id_residence', 'id');
    }

}
