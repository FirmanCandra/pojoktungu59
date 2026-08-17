<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        Announcement::create([
            'title'     => '[KLARIFIKASI HOAX] Berita Palsu Pembagian Bantuan Tunai Tanpa Syarat',
            'content'   => 'Beredar pesan berantai di WhatsApp mengenai pembagian bantuan tunai Rp 1.500.000 atas nama Pemerintah Desa Tungu. Dipastikan informasi tersebut adalah HOAX (PALSU). Harap tidak mengklik tautan misterius atau menyebarkan pesan tersebut.',
            'type'      => 'hoax',
            'is_active' => true,
        ]);

        Announcement::create([
            'title'     => '[HIMBAUAN PENTING] Waspada Modus Penipuan Berkedok Tim KKN',
            'content'   => 'Seluruh kegiatan KKN Kelompok 59 Desa Tungu TIDAK MEMUNGUT BIAYA APAPUN dari warga. Harap berhati-hati jika ada oknum yang meminta sumbangan mengatasnamakan tim KKN.',
            'type'      => 'warning',
            'is_active' => true,
        ]);
    }
}
