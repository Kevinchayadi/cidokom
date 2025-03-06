<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustHandle extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_sales',
        'diskon',
    ];
    public function customers(){
        return $this->hasMany(Customer::class,'id_sales', 'id');
    }
}
