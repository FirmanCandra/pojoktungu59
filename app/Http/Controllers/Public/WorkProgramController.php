<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\WorkProgram;
use Illuminate\Http\Request;

class WorkProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = WorkProgram::query();

        if ($request->filled('status') && in_array($request->status, ['berjalan', 'selesai'])) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('category', $request->kategori);
        }

        $workPrograms = $query->latest()->paginate(9)->withQueryString();

        return view('public.work-programs.index', compact('workPrograms'));
    }

    public function show(string $slug)
    {
        $program = WorkProgram::where('slug', $slug)->firstOrFail();
        $others  = WorkProgram::where('id', '!=', $program->id)->latest()->take(3)->get();

        return view('public.work-programs.show', compact('program', 'others'));
    }
}
