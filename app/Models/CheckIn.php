<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
{
    use HasFactory;

    protected $table = 'checkins';

    protected $fillable = [
        'trip_id',
        'latitude',
        'longitude',
        'location_name',
        'fuel_level',
        'passengers',
        'notes',
        'checked_at',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'fuel_level' => 'float',
        'checked_at' => 'datetime',
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
