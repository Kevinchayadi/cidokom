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
        'machine_name',
        'setting_date',
        'candling_date',
        'pull_chicken_date',
        'input_by',
        'input_at',
        'move_to',
        'status'
    ];
    
    
    public function hatcheryDetails()
    {
        return $this->hasMany(Hatchery_detail::class,'id_hatchery','id_hatchery');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            
            $time = Carbon::now()->format('dmy');
    
            
            $count = Hatchery::where('id_pen', $model->id_pen)->count() + 1;

            $count_formatted = str_pad($count, 3, '0', STR_PAD_LEFT);
    
            $model->id_hatchery = 'HTC-' . $time . '-' . $count_formatted;
        });

    }
}
