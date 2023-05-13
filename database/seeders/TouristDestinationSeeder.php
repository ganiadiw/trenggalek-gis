<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TouristDestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tourist_destinations')->insert([
            [
                'sub_district_id' => 3,
                'category_id' => 4,
                'name' => 'Panjat Tebing Gunung Sepikul',
                'slug' => str()->slug('Panjat Tebing Gunung Sepikul') . '-' . str()->random(5),
                'manager' => 'VIA VERATA',
                'address' => 'Desa Watuagung, Kecamatan Watulimo',
                'description' => '<p>Kabupaten Trenggalek yang terletak di pesisir selatan Jawa Timur ini memang mempunyai wisata yang beragam, unik serta menantang. Salah satu wisata yang unik ini adalah Wisata panjat tebing melalui jalur khusus atau yang biasa disebut dengan Via Ferrata yang dibuka untuk umum dan merupakan yang pertama di Jawa Timur. Lokasi Via Ferrata ini berada di Gunung Sepikul Desa Watuagung Kecamatan Watulimo sehingga wisata ini dinamakan Sepikul Via Ferrata atau Sparta. Wisata Via Ferrata berasal dari bahasa Italia yang artinya jalur besi. Jalur Via Ferrata di Trenggalek yang mulai dibangun sejak Juni 2017 dibagi menjadi dua spot pendakian, dengan ketinggian sekitar 150 meter di atas permukaan laut (mdpl) dan 250 mdpl dan wisata panjat tebing dibagi dalam tiga paket, paket pertama disebut Apache Route dengan ketinggian 125 meter dan biayanya sebesar Rp. 125.000 / Pax. , Paket kedua yang disebut dengan Spartan Route dengan ketinggian 225 m dengan biaya Rp. 225.000 / Pax. dan paket ketiga disebut dengan Spartan Plus ini dengan ketinggian 225 m dengan fasilitas yang berbeda dengan biaya Rp. 350.000 / Pax. Nah yang menakjubkan lagi dari atas ketinggian Tebing Sepikul wisatawan bisa menikmati panorama yang menakjubkan yang masih asri.</p><p> </p><p>Wisatawan tidak usah merasa khawatir pasalnya oleh team sudah dilengkapi dengan beberapa alat keamanan yang safety yang digunakan untuk Climbing di Gunung Sepikul misalnya yang wajib digunakan oleh Wisatawan  : helm, lanyard, maupun harness. Sebelum memanjat tebing, para wisatawan dibriefing oleh team Sparta. Via Ferrata di Trenggalek merupakan yang kedua di Indonesia. Wisata Via Ferrata pertama ada di Tebing Parang, Purwakarta, Jawa Barat. Diharapkan wisata baru ini akan menjadi daya tarik tersendiri bagi wisatawan. Wisata minat khusus ini merupakan kerjasama antara CV Indo Via Ferrata, Perhutani dan LMDH (Lembaga Masyarakat Desa Hutan) dengan investor swasta sebagai operator pelaksana. Keberadaannya diharapkan mampu membangkitkan daya tarik wisata di Kabupaten Trenggalek, sekaligus melengkapi berbagai destinasi wisata yang telah ada sebelumnya.</p><div><div><div> </div><div><div><div> </div><div><p> </p><p> </p></div></div></div></div></div>',
                'distance_from_city_center' => '26 KM',
                'transportation_access' => 'Bisa diakses dengan mobil dan sepeda motor',
                'facility' => 'Homestay, Camping Ground',
                'cover_image_name' => 'image.jpg',
                'cover_image_path' => '/storage/app/public/images/cover_image/image.jpg',
                'latitude' => -8.20331637,
                'longitude' => 111.71746020,
            ],
            [
                'sub_district_id' => 1,
                'category_id' => 1,
                'name' => 'Pantai Konang',
                'slug' => str()->slug('Pantai Konang') . '-' . str()->random(5),
                'manager' => 'LDMH',
                'address' => 'Desa Nglebeng, Kecamatan Panggul',
                'description' => '<p>Terkenal dengan keindahan pantai dan kuliner ikan bakar</p>',
                'distance_from_city_center' => '56 KM',
                'transportation_access' => 'Bisa diakses dengan bus, mobil, dan sepeda motor',
                'facility' => 'MCK, Mushola, Lahan Parkir',
                'cover_image_name' => 'image.jpg',
                'cover_image_path' => '/storage/app/public/images/cover_image/image.jpg',
                'latitude' => -8.27466803,
                'longitude' => 111.45297354,
            ],
        ]);
    }
}
