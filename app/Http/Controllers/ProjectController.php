<?php

namespace App\Http\Controllers;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::latest()->get();
    }

    public function store(Request $request)
    {
        if (is_string($request->tags)) {
            $request->merge(['tags' => json_decode($request->tags, true)]);
        }
        if (is_string($request->features)) {
            $request->merge(['features' => json_decode($request->features, true)]);
        }

        $data = $request->validate([
            'title' => 'required|string',
            'category' => 'required|string',
            'catIcon' => 'nullable|string',
            'desc' => 'nullable|string',
            'fullDesc' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'tags' => 'nullable|array',
            'year' => 'nullable|string',
            'type' => 'nullable|string',
            'downloadUrl' => 'nullable|string',
            'features' => 'nullable|array',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('projects', 'public');
            $data['image'] = Storage::url($path);
        }

        return Project::create($data);
    }

    public function show(Project $project)
    {
        return $project;
    }

    public function update(Request $request, Project $project)
    {
        if (is_string($request->tags)) {
            $request->merge(['tags' => json_decode($request->tags, true)]);
        }
        if (is_string($request->features)) {
            $request->merge(['features' => json_decode($request->features, true)]);
        }

        $data = $request->validate([
            'title' => 'required|string',
            'category' => 'required|string',
            'catIcon' => 'nullable|string',
            'desc' => 'nullable|string',
            'fullDesc' => 'nullable|string',
            'image' => 'nullable', // Could be file or string
            'tags' => 'nullable|array',
            'year' => 'nullable|string',
            'type' => 'nullable|string',
            'downloadUrl' => 'nullable|string',
            'features' => 'nullable|array',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($project->image) {
                $oldPath = str_replace('/storage/', '', $project->image);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('image')->store('projects', 'public');
            $data['image'] = Storage::url($path);
        }

        $project->update($data);
        return $project;
    }

    public function destroy(Project $project)
    {
        if ($project->image) {
            $oldPath = str_replace('/storage/', '', $project->image);
            Storage::disk('public')->delete($oldPath);
        }
        $project->delete();
        return response()->noContent();
    }
}
