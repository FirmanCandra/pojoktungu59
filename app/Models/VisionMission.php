<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisionMission extends Model
{
    protected $fillable = ['vision', 'mission'];

    /**
     * Get the singleton instance (always the first row).
     */
    public static function getInstance(): self
    {
        return static::firstOrCreate([], [
            'vision'  => 'Menjadi sumber informasi yang terpercaya dan bermanfaat bagi masyarakat.',
            'mission' => "1. Menyajikan informasi yang akurat dan aktual.\n2. Mendorong literasi digital di masyarakat.\n3. Menjadi jembatan antara teknologi dan kehidupan sehari-hari.",
        ]);
    }
}
