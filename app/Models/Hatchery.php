<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hatchery extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_hatchery';
    public $incrementing = false;
// protected $keyType = 'string';
    protected $fillable = [
        'id_hatchery',
        'id_pen',
        'id_machine',
        'setting_date',
        'candling_date',
        'pull_chicken_date',
        'cost_total',
        'move_to',
        'status',
        'inputBy'
    ];
    
    
    public function hatcheryDetails()
    {
        return $this->hasMany(Hatchery_detail::class,'id_hatchery','id_hatchery');
    }
    public function machine()
    {
        return $this->belongsTo(Machine::class,'id_machine','id');
    }
    public function pen()
    {
        return $this->belongsTo(Pen::class,'id_pen','id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            
            $time = Carbon::now()->format('dmy');
    
            
            // $count = Hatchery::where('id_pen', $model->id_pen)->count() + 1;

            $count_formatted = str_pad($model->id_machine, 2, '0', STR_PAD_LEFT);
    
            $model->id_hatchery = 'HTC-' . $time . '-' . $count_formatted;
        });

    }
}
