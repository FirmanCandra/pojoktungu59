<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    private array $keys = [
        'site_name', 'site_tagline', 'address', 'phone', 'email',
        'maps', 'instagram', 'tiktok', 'facebook',
    ];

    public function edit()
    {
        $settings = [];
        foreach ($this->keys as $key) {
            $settings[$key] = SiteSetting::get($key);
        }
        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:100',
            'email'     => 'nullable|email',
        ]);

        foreach ($this->keys as $key) {
            SiteSetting::set($key, $request->input($key, ''));
        }

        return redirect()->route('admin.settings.edit')->with('success', 'Pengaturan situs berhasil disimpan.');
    }
}
