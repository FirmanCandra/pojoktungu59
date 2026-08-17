<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);

        $articles = [
            [
                'title'     => 'Membangun Desa Digital: Peluang dan Tantangan di Era Teknologi',
                'category'  => 'Desa',
                'content'   => "Transformasi digital kini telah merambah hingga ke pelosok desa. Kehadiran teknologi informasi bukan sekadar gaya hidup, melainkan solusi nyata untuk meningkatkan kualitas layanan publik, efisiensi administrasi desa, dan potensi perekonomian lokal.\n\nDalam artikel ini, kita membahas bagaimana internet dan aplikasi desa dapat membantu pelayanan administrasi mandiri serta mendorong UMKM lokal berkembang.",
                'status'    => 'published',
                'thumbnail' => null,
            ],
            [
                'title'     => 'Belajar HTML & CSS Dasar untuk Pemula',
                'category'  => 'Pemrograman',
                'content'   => "Panduan lengkap belajar HTML dan CSS dari dasar hingga mampu membuat tampilan website sederhana.\n\nMemahami struktur tag HTML dan sintaks styling CSS adalah langkah pertama yang paling fundamental bagi calon web developer modern.",
                'status'    => 'published',
                'thumbnail' => null,
            ],
            [
                'title'     => 'Tips Belajar Efektif bagi Mahasiswa & Pemuda',
                'category'  => 'Pendidikan',
                'content'   => "Temukan cara mengatur waktu, membuat catatan terstruktur, dan meningkatkan fokus saat belajar di tengah godaan media sosial.\n\nTeknik Pomodoro dan penyusunan jadwal prioritas terbukti ampuh meningkatkan produktivitas akademik.",
                'status'    => 'published',
                'thumbnail' => null,
            ],
            [
                'title'     => 'Potensi Wisata Desa yang Menjanjikan di Tahun 2026',
                'category'  => 'Desa',
                'content'   => "Menggali potensi wisata alam dan kebudayaan desa yang dapat meningkatkan ekonomi masyarakat lokal secara berkelanjutan.\n\nPengelolaan berbasis agrowisata dan ekowisata menjadi pilihan populer generasi muda.",
                'status'    => 'published',
                'thumbnail' => null,
            ],
            [
                'title'     => 'Perkembangan Artificial Intelligence (AI) di Tahun 2026',
                'category'  => 'Teknologi',
                'content'   => "Kecerdasan buatan semakin canggih dan berpengaruh pada berbagai sektor kehidupan seperti kesehatan, pendidikan, dan otomatisasi kerja.\n\nMemahami cara kerja alat-alat AI membantu kita beradaptasi di dunia industri modern.",
                'status'    => 'published',
                'thumbnail' => null,
            ],
            [
                'title'     => 'Panduan Keamanan Data Pribadi di Era Digital',
                'category'  => 'Teknologi',
                'content'   => "Langkah sederhana untuk menjaga data pribadi tetap aman di internet, mulai dari aktivasi Two-Factor Authentication (2FA) hingga mengenali phising email.",
                'status'    => 'draft',
                'thumbnail' => null,
            ],
        ];

        foreach ($articles as $art) {
            Article::create(array_merge($art, [
                'user_id'      => $admin->id,
                'published_at' => $art['status'] === 'published' ? now()->subDays(rand(1, 10)) : null,
            ]));
        }
    }
}
