<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;
use App\Models\SiteSetting;

class ContactController extends Controller
{
    public function index()
    {
        $settings = [
            'address'   => SiteSetting::get('address', 'Jl. Contoh No. 1, Indonesia'),
            'phone'     => SiteSetting::get('phone', '+62 812-3456-7890'),
            'email'     => SiteSetting::get('email', 'info@pojokinfo.id'),
            'maps'      => SiteSetting::get('maps', ''),
            'instagram' => SiteSetting::get('instagram', '#'),
            'facebook'  => SiteSetting::get('facebook', '#'),
            'twitter'   => SiteSetting::get('twitter', '#'),
            'youtube'   => SiteSetting::get('youtube', '#'),
        ];

        return view('public.contact', compact('settings'));
    }

    public function store(StoreContactMessageRequest $request)
    {
        ContactMessage::create($request->validated());

        return redirect()->route('contact')->with('success', 'Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda.');
    }
}
