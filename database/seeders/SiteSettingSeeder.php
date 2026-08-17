<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'site_name'    => 'Pojok Informasi',
            'site_tagline' => 'Informasi Aktual, Inspiratif, dan Bermanfaat',
            'address'      => 'WPC7+H8Q, Tungu, Kec. Godong, Kabupaten Grobogan, Jawa Tengah 58162',
            'phone'        => '+62 812-3456-7890',
            'email'        => 'redaksi@pojokinfo.id',
            'maps'         => '<iframe src="https://maps.google.com/maps?q=WPC7%2BH8Q%2C+Tungu%2C+Kec.+Godong%2C+Kabupaten+Grobogan%2C+Jawa+Tengah+58162%2C+Indonesia&t=&z=15&ie=UTF8&iwloc=&output=embed" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            'instagram'    => 'https://www.instagram.com/tindak.tungu',
            'tiktok'       => 'https://www.tiktok.com/@kkn.desatungu59',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::set($key, $value);
        }
    }
}
