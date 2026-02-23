<?php
namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;

class ProjectsController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        return Project::with('category')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'projectname' => 'required',
            'description' => 'required',
            'slug' => 'required|unique:projects,slug',
            'category_id' => 'required|exists:categories,id',
        ]);

        $data['user_id'] = auth()->id();
        $project = Project::create($data);

        return response()->json($project, 201);
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);
        return response()->json($project->load('category'));
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $data = $request->validate([
            'projectname' => 'sometimes|required',
            'description' => 'sometimes|required',
            'slug' => ['sometimes','required',
            Rule::unique('projects', 'slug')->ignore($project->id),
            ],
            'category_id'  => 'sometimes|required|exists:categories,id',
        ]);

        $project->update($data);
        return response()->json($project);
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();

        return response()->json(['deleted' => true]);
    }
}