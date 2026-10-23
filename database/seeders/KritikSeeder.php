<?php

namespace Database\Seeders;

use App\Models\Kritik;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class KritikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Kritik::create(1000)->create();

        $faker = Faker::create('id_ID');
        for ($loop = 1; $loop <= 1000; $loop++) {
            Kritik::create([
                'isi' => $faker->text($maxNbChars = 200),
                'film_id' => $faker->numberBetween(1, 128),
                'user_id' => $faker->numberBetween(1, 10),
            ]);
        }
    }
}
