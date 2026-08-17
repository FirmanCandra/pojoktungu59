<?php

namespace Database\Seeders;

use App\Models\WorkProgram;
use Illuminate\Database\Seeder;

class WorkProgramSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [
            [
                'title'       => 'Pelatihan Literasi Digital & Pembuatan Website Desa',
                'description' => 'Program pelatihan untuk perangkat desa dan pemuda setempat mengenai pengelolaan sistem informasi desa dan publikasi berita daerah.',
                'status'      => 'berjalan',
                'start_date'  => '2026-05-01',
                'end_date'    => '2026-06-30',
            ],
            [
                'title'       => 'Pendataan & Pemberdayaan UMKM Lokal',
                'description' => 'Mendata pelaku usaha mikro dan membantu pemasaran produk desa secara digital melalui catalog online.',
                'status'      => 'berjalan',
                'start_date'  => '2026-04-15',
                'end_date'    => '2026-07-15',
            ],
            [
                'title'       => 'Pengadaan Pojok Baca & Ruang Belajar Masyarakat',
                'description' => 'Penyediaan sarana tempat membaca dan belajar gratis yang dilengkapi buku-buku edukatif dan koneksi internet publik.',
                'status'      => 'selesai',
                'start_date'  => '2026-01-10',
                'end_date'    => '2026-03-20',
            ],
            [
                'title'       => 'Sosialisasi Keamanan Pangan & Pola Hidup Sehat',
                'description' => 'Kegiatan edukasi kesehatan untuk ibu dan anak bekerjasama dengan puskesmas setempat.',
                'status'      => 'selesai',
                'start_date'  => '2026-02-01',
                'end_date'    => '2026-02-28',
            ],
        ];

        foreach ($programs as $prog) {
            WorkProgram::create($prog);
        }
    }
}
