<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate_number',
        'vehicle_type',
        'brand',
        'model',
        'year',
        'capacity',
        'color',
        'description',
        'status',
        'fuel_capacity',
        'fuel_consumption',
    ];

    protected $casts = [
        'fuel_capacity' => 'float',
        'fuel_consumption' => 'float',
    ];

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function maintenances()
    {
        return $this->hasMany(VehicleMaintenance::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
