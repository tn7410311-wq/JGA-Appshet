<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleMaintenance extends Model
{
    use HasFactory;

    protected $table = 'vehicle_maintenances';

    protected $fillable = [
        'vehicle_id',
        'maintenance_type',
        'description',
        'maintenance_date',
        'cost',
        'mileage',
        'next_maintenance_date',
        'notes',
    ];

    protected $casts = [
        'cost' => 'float',
        'maintenance_date' => 'date',
        'next_maintenance_date' => 'date',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
