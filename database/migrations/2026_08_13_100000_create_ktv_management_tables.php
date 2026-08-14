<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drivers table
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('license_number')->unique();
            $table->string('license_plate');
            $table->text('address')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->date('license_expiry')->nullable();
            $table->timestamps();
            $table->index('status');
        });

        // Vehicles table
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number')->unique();
            $table->string('vehicle_type'); // Car, Van, Truck, etc.
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->integer('capacity'); // Seats or tons
            $table->string('color')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'maintenance', 'inactive'])->default('active');
            $table->decimal('fuel_capacity', 8, 2); // Liters
            $table->decimal('fuel_consumption', 5, 2); // Liters per 100km
            $table->timestamps();
            $table->index('status');
        });

        // Routes table
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('start_location');
            $table->string('end_location');
            $table->decimal('distance', 8, 2); // KM
            $table->integer('estimated_time'); // Minutes
            $table->decimal('standard_fuel_cost', 10, 2);
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->index('status');
        });

        // Trips table
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('restrict');
            $table->foreignId('driver_id')->constrained('drivers')->onDelete('restrict');
            $table->foreignId('route_id')->constrained('routes')->onDelete('restrict');
            $table->dateTime('departure_time');
            $table->dateTime('arrival_time')->nullable();
            $table->decimal('distance_traveled', 8, 2)->nullable();
            $table->decimal('fuel_used', 8, 2)->nullable();
            $table->integer('passengers')->default(0);
            $table->text('notes')->nullable();
            $table->enum('status', ['planned', 'in_progress', 'completed', 'cancelled'])->default('planned');
            $table->timestamps();
            $table->index('status');
            $table->index(['vehicle_id', 'driver_id']);
        });

        // CheckIns table
        Schema::create('checkins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained('trips')->onDelete('cascade');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('location_name');
            $table->decimal('fuel_level', 5, 2)->nullable(); // Percent
            $table->integer('passengers')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('checked_at');
            $table->timestamps();
            $table->index('trip_id');
        });

        // Expenses table
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->nullable()->constrained('trips')->onDelete('set null');
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('restrict');
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->onDelete('set null');
            $table->string('expense_type'); // Fuel, Maintenance, Tolls, etc.
            $table->decimal('amount', 10, 2);
            $table->text('description');
            $table->string('receipt_number')->nullable();
            $table->date('expense_date');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['trip_id', 'vehicle_id']);
        });

        // Vehicle Maintenance table
        Schema::create('vehicle_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->string('maintenance_type');
            $table->text('description');
            $table->date('maintenance_date');
            $table->decimal('cost', 10, 2);
            $table->integer('mileage')->nullable();
            $table->date('next_maintenance_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index('vehicle_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_maintenances');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('checkins');
        Schema::dropIfExists('trips');
        Schema::dropIfExists('routes');
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('drivers');
    }
};
