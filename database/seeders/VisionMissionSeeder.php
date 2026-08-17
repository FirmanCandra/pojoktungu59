<?php

namespace Database\Seeders;

use App\Models\VisionMission;
use Illuminate\Database\Seeder;

class VisionMissionSeeder extends Seeder
{
    public function run(): void
    {
        VisionMission::updateOrCreate(
            ['id' => 1],
            [
                'vision'  => 'Menjadi pusat informasi dan publikasi kegiatan yang inspiratif, transparan, dan berdampak positif bagi kemajuan masyarakat dan kegiatan KKN.',
                'mission' => "1. Menyajikan berita dan artikel yang akurat, terpercaya, dan mendidik secara berkala.\n2. Mengedukasi dan mendorong pemanfaatan teknologi digital di lingkungan masyarakat.\n3. Mempublikasikan seluruh program kerja dan agenda KKN secara transparan.\n4. Membangun ruang komunikasi yang responsif antara tim KKN dan masyarakat.",
            ]
        );
    }
}
