<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_Resident',
        'tipe'
    ];

    public function Customers(){
        return $this->hasMany(Customer::class,'id_residence','id');
    }
}
