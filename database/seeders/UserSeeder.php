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
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'username' => 'superadmin',
                'address' => 'Kecamatan Trenggalek',
                'phone_number' => '081234567890',
                'is_admin' => 1,
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Webgis Admin',
                'email' => 'webgisadmin@example.com',
                'username' => 'webgisadmin',
                'address' => 'Kecamatan Karangan',
                'phone_number' => '081234567891',
                'is_admin' => 0,
                'password' => Hash::make('password'),
            ]
        ]);
    }
}
