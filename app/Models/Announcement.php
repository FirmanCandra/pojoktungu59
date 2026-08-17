<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['title', 'content', 'type', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Returns a CSS color class based on type for badge styling
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'hoax'    => '🚫 Klarifikasi Hoax',
            'warning' => '⚠️ Peringatan',
            'penting' => '📢 Penting',
            default   => 'ℹ️ Informasi',
        };
    }

    public function getTypeBadgeColorAttribute(): string
    {
        return match($this->type) {
            'hoax'    => '#dc2626',
            'warning' => '#d97706',
            'penting' => '#7c3aed',
            default   => '#145bd7',
        };
    }
}
