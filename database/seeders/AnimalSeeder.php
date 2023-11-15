<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\Zone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Check if the new property exists in the table
        if (Schema::hasColumn('animals', 'zone_id')) {
            // Make sure the zones table is seeded or has data
            if (Zone::count() > 0) {
                Zone::each(function ($zone) {
                    // Use the Zone model's relation to create animals
                    $zone->animals()->saveMany(
                        Animal::factory(8)->make() // Adjust the number of animals as needed
                    );
                });
            } else {
                // Handle the case where there are no zones available
                $this->command->info('No zones available. Seed the zones table first.');
            }
        }

    }
}
