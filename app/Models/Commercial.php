<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commercial extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_commercial',
        'id_pen',
        'entryDate',
        'entry_population',
        'last_population',
        'age',
        'total_cost',
        'unit_cost',
        'inputBy',
        'status'

    ];

    public function commercialDetails()
    {
        return $this->hasMany(Commercial_detail::class, 'id_commercial', 'id_commercial');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            
            $pen = Pen::find($model->id_pen); 
            $code_pen = $pen->code_pen;
            $kandang = Kandang::find($pen->id_kandang);
            $code_kandang = $kandang->nama_kandang;
    
            
            $year = Carbon::now()->format('my'); 
    
            
            $count = Commercial::where('id_pen', $model->id_pen)->count() + 1;

            $count_formatted = str_pad($count, 3, '0', STR_PAD_LEFT);
    
            $model->id_commercial =  $code_kandang .'-' . $code_pen . '-' . $year . '-' .  $count_formatted;
        });

    }
}
