<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        Vehicle::insert([
            [
                'name'         => 'Toyota Avanza',
                'type'         => 'mobil',
                'price_per_day'=> 300000,
                'status'       => 'tersedia',
                'description'  => 'Mobil keluarga, kapasitas 7 penumpang',
                'image'        => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'Honda Beat',
                'type'         => 'motor',
                'price_per_day'=> 75000,
                'status'       => 'tersedia',
                'description'  => 'Motor matic irit, cocok untuk dalam kota',
                'image'        => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}