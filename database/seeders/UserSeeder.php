<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Gani Adi',
            'last_name' => 'Wiranata',
            'email' => 'ganiadiw@example.com',
            'username' => 'ganiadiw',
            'address' => 'Desa Gayam, Kecamatan Panggul',
            'phone_number' => '081234567890',
            'is_admin' => 1,
            'password' => Hash::make('password'),
        ]);

        $faker = Faker::create('id_ID');

        for ($i=0; $i < 20; $i++) {
            User::create([
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $faker->safeEmail(),
                'username' => $faker->userName(),
                'address' => $faker->address(),
                'phone_number' => $faker->phoneNumber(),
                'is_admin' => 0,
                'password' => Hash::make('password'),
            ]);
        }
    }
}
