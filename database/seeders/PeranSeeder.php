<?php

namespace Database\Seeders;

use App\Models\Cast;
use App\Models\Film;
use App\Models\Peran;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class PeranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $castIds = Cast::pluck('id');

        if ($castIds->isEmpty()) {
            $this->command?->warn('PeranSeeder: data cast belum tersedia, data dilewati.');

            return;
        }

        // Pastikan setiap film memiliki minimal tiga pemeran di tabel pivot perans.
        foreach (Film::all() as $film) {
            $castForFilm = $castIds->shuffle()->take(min(3, $castIds->count()));

            foreach ($castForFilm as $castId) {
                Peran::updateOrCreate(
                    [
                        'film_id' => $film->id,
                        'cast_id' => $castId,
                    ],
                    [
                        'actor' => $faker->jobTitle,
                    ]
                );
            }
        }
    }
}
