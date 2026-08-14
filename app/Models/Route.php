<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'start_location',
        'end_location',
        'distance',
        'estimated_time',
        'standard_fuel_cost',
        'description',
        'status',
    ];

    protected $casts = [
        'distance' => 'float',
        'standard_fuel_cost' => 'float',
    ];

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
