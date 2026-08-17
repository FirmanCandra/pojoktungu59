<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisionMission;
use Illuminate\Http\Request;

class VisionMissionController extends Controller
{
    public function edit()
    {
        $visionMission = VisionMission::getInstance();
        return view('admin.vision-mission.edit', compact('visionMission'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'vision'  => 'required|string',
            'mission' => 'required|string',
        ]);

        $visionMission = VisionMission::getInstance();
        $visionMission->update($request->only('vision', 'mission'));

        return redirect()->route('admin.vision-mission.edit')->with('success', 'Visi & Misi berhasil diperbarui.');
    }
}
