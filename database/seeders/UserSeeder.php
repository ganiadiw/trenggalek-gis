<?php

namespace Database\Seeders;

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
                'name' => 'Gani Adi Wiranata',
                'email' => 'ganiadwata@gmail.com',
                'username' => 'ganiadiw',
                'address' => 'Desa Gayam, Kecamatan Panggul, Kabupaten Trenggalek',
                'phone_number' => '082245815497',
                'is_admin' => 1,
                'password' => Hash::make('@sandiwisatatrenggalek28'),
            ],
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'username' => 'superadmin',
                'address' => 'Kecamatan Trenggalek',
                'phone_number' => '081234567890',
                'is_admin' => 1,
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Webgis Admin',
                'email' => 'webgisadmin@gmail.com',
                'username' => 'webgisadmin',
                'address' => 'Kecamatan Karangan',
                'phone_number' => '081234567891',
                'is_admin' => 0,
                'password' => Hash::make('password123'),
            ],
        ]);
    }
}
