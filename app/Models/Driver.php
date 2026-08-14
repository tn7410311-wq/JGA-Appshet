<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'license_number',
        'license_plate',
        'address',
        'status',
        'license_expiry',
    ];

    protected $casts = [
        'license_expiry' => 'date',
    ];

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
