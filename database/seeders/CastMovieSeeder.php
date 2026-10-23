<?php

namespace Database\Seeders;

use App\Models\Cast;
use App\Models\Film;
use Illuminate\Database\Seeder;

class CastMovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contoh isi seeder: menghubungkan film ID 7 ("Keanu") dengan beberapa pemeran.
        // Key = cast_id (pemeran), Value = peran yang dimainkan oleh pemeran tersebut.
        $roles = [
            28 => 'Protagonis Utama',
            9 => 'Sekretaris Pribadi',
            11 => 'Partner Kerja',
            26 => 'Istri',
            29 => 'Antagonis',
            17 => 'Investigator',
        ];

        $film = Film::find(7);

        if (! $film) {
            $this->command?->warn('CastMovieSeeder: film ID 7 tidak ditemukan, data dilewati.');

            return;
        }

        // Abaikan pemeran yang belum tersedia di database.
        $validCastIds = Cast::whereIn('id', array_keys($roles))->pluck('id');

        $attach = [];
        foreach ($roles as $castId => $role) {
            if ($validCastIds->contains($castId)) {
                $attach[$castId] = ['role' => $role];
            }
        }

        if ($attach === []) {
            $this->command?->warn('CastMovieSeeder: tidak ada pemeran yang valid, data dilewati.');

            return;
        }

        // syncWithoutDetaching() menambahkan relasi baru tanpa menghapus relasi
        // yang sudah ada, sehingga seeder ini aman dijalankan berulang kali.
        // Kolom 'role' terisi otomatis karena relasi memakai withPivot('role').
        $film->castMovie()->syncWithoutDetaching($attach);

        $this->command?->info('CastMovieSeeder: '.$film->title.' terhubung dengan '.count($attach).' pemeran.');

        // Alternatif penulisan yang sama tanpa helper relasi:
        //
        // DB::table('cast_movie')->upsert(
        //     collect($attach)->map(fn ($role, $castId) => [
        //         'film_id'    => 7,
        //         'cast_id'    => $castId,
        //         'role'       => $role['role'],
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ])->values()->all(),
        //     ['film_id', 'cast_id'],
        //     ['role']
        // );
    }
}
