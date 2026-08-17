<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'url',
        'session_id',
    ];

    /** Total pengunjung unik (berdasarkan IP) */
    public static function totalUniqueVisitors(): int
    {
        return static::distinct('ip_address')->count('ip_address');
    }

    /** Pengunjung unik hari ini */
    public static function todayUniqueVisitors(): int
    {
        return static::whereDate('created_at', today())
            ->distinct('ip_address')
            ->count('ip_address');
    }

    /** Pengunjung unik per hari selama N hari terakhir */
    public static function dailyVisitors(int $days = 7): array
    {
        $data = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $data[now()->subDays($i)->format('d M')] = static::whereDate('created_at', $date)
                ->distinct('ip_address')
                ->count('ip_address');
        }
        return $data;
    }
}
