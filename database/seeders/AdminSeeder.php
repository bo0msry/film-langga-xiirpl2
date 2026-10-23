<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $profile = Profile::firstOrNew(['bio' => 'administrator']);

        if (! $profile->exists) {
            $profile->forceFill([
                'alamat' => $faker->address,
                'umur' => $faker->numberBetween(1, 50),
            ])->save();
        }

        $role = Role::firstOrCreate(['name' => 'admin']);

        $user = User::firstOrNew(['email' => 'admin@gmail.com']);

        $user->forceFill([
            'name' => 'admin',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'role_id' => $role->id,
            'profile_id' => $profile->id,
        ])->save();
    }
}
