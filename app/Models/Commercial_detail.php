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
        'move_to',
        'total_move',
        'receive_from',
        'total_recieve',
        'feed',
        'feed_name',
        'inputBy'

    ];

    public function commercial()
    {
        return $this->belongsTo(Commercial::class, 'id_breeding', 'id');
    }
}
