<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commercial_detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_commercial',
        'date',
        'begining_population',
        'last_population',
        'depreciation_die',
        'depreciation_afkir',
        'depreciation_panen',
        'feed',
        'feed_name',
        'id_admin',

    ];

    public function commercial()
    {
        return $this->belongsTo(Commercial::class, 'id_breeding', 'id');
    }
}
