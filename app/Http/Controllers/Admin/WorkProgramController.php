<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorkProgramRequest;
use App\Http\Requests\UpdateWorkProgramRequest;
use App\Models\WorkProgram;
use Illuminate\Support\Facades\Storage;

class WorkProgramController extends Controller
{
    public function index()
    {
        $workPrograms = WorkProgram::latest()->paginate(15);
        return view('admin.work-programs.index', compact('workPrograms'));
    }

    public function create()
    {
        return view('admin.work-programs.create');
    }

    public function store(StoreWorkProgramRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = WorkProgram::generateUniqueSlug($data['title']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('programs', 'public');
        }

        WorkProgram::create($data);

        return redirect()->route('admin.program-kerja.index')->with('success', 'Program kerja berhasil ditambahkan.');
    }

    public function show(WorkProgram $workProgram)
    {
        return view('admin.work-programs.show', compact('workProgram'));
    }

    public function edit(WorkProgram $workProgram)
    {
        return view('admin.work-programs.edit', compact('workProgram'));
    }

    public function update(UpdateWorkProgramRequest $request, WorkProgram $workProgram)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($workProgram->image) {
                Storage::disk('public')->delete($workProgram->image);
            }
            $data['image'] = $request->file('image')->store('programs', 'public');
        }

        $workProgram->update($data);

        return redirect()->route('admin.program-kerja.index')->with('success', 'Program kerja berhasil diperbarui.');
    }

    public function destroy(WorkProgram $workProgram)
    {
        if ($workProgram->image) {
            Storage::disk('public')->delete($workProgram->image);
        }
        $workProgram->delete();

        return redirect()->route('admin.program-kerja.index')->with('success', 'Program kerja berhasil dihapus.');
    }
}
