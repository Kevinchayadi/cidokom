<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vaksin extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 
        'typr',
        'deskripsi'
    ];

    public function breedings()
    {
        return $this->belongsToMany(Breeding::class, 'commercial_breeding_vaccine', 'vaccine_id', 'breeding_id');
    }

    // Relasi Many-to-Many dengan Commercial melalui tabel pivot
    public function commercials()
    {
        return $this->belongsToMany(Commercial::class, 'commercial_breeding_vaccine', 'vaccine_id', 'commercial_id');
    }
}
