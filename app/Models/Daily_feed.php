<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daily_feed extends Model
{
    use HasFactory;
    protected $fillable=[
        'id_pen',
        'id_pakan',
        'qty',
        'stock_feed'
    ];
    public function pakan(){
        return $this->belongsTo(Pakan::class, 'id_pakan', 'id');
    }
    public function pen(){
        return $this->belongsTo(pen::class, 'id_pen', 'id');
    }
}
