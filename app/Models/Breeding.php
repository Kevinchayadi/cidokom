<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breeding extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_breeding';
    public $incrementing = false;
    protected $fillable = [
        'id_breeding',
        'id_pen',
        'cost_induk',
        'code_ayam_jantan',
        'code_ayam_betina',
        'jumlah_jantan',
        'jumlah_betina',
        'cost_Total_induk',
        'cost_induk',
        'age',
        'status',
        'inputBy'
    ];

    public function vaksin()
    {
        return $this->belongsToMany(vaksin::class, 'commercial_breeding_vaccine', 'id_breeding', 'vaccine_id');
    }

    public function breedingDetails()
    {
        return $this->hasMany(Breeding_detail::class, 'id_breeding');
    }
    public function pen()
    {
        return $this->belongsTo(Pen::class, 'id_pen', 'id');
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
    
            
            $count = Breeding::where('id_pen', $model->id_pen)->count() + 1;

            $count_formatted = str_pad($count, 3, '0', STR_PAD_LEFT);
    
            $model->id_breeding =  $code_kandang .'-' . $code_pen . '-' . $year . '-' .  $count_formatted;
        });

    }
}
