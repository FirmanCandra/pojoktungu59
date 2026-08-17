<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\VisionMission;

class VisionMissionController extends Controller
{
    public function index()
    {
        $visionMission = VisionMission::getInstance();
        return view('public.vision-mission', compact('visionMission'));
    }
}
