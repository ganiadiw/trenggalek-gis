<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
            'name' => 'Gani Adi Wiranata',
            'email' => 'ganiadiw@example.com',
            'username' => 'ganiadiw',
            'address' => 'Desa Gayam, Kecamatan Panggul',
            'phone_number' => '081234567890',
            'is_admin' => 1,
            'password' => Hash::make('password'),
        ]);

        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 20; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name(),
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
