<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProjectsUpdateRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\ProjectsRequest;
class ProjectsController extends Controller
{
    use AuthorizesRequests;

     public function index() {
       $projects = Project::with(['category', 'article', 'workspace'])
       ->visibleTo(auth()->user())->get();
        return response()->json($projects);
        
    }
    public function store(ProjectsRequest $request)
    {
        $this->authorize('create', Project::class);
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        return Project::create($data);
    }
    public function show(Project $project)
    {
        $this->authorize('view', $project);
        return $project->load(['category', 'article', 'workspace']);
    }
    public function update(ProjectsUpdateRequest $request, Project $project)
    {
        $this->authorize('update', $project);
        $data = $request->validated();
        $project->update($data);    
        return $project;
        }
    
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();
        
        return response()->json(['deleted' => true]);
    }
    public function AdminIndex(Request $request) {
        $query = Project::with(['category', 'article', 'workspace']);
        if ($request->user_id) {
        $query->where('user_id', $request->user_id);
         };
        
         return response()->json($query->get());
    }
     
    
    public function myProjects()
{
    $projects = Project::with(['category', 'article', 'workspace'])
    ->visibleTo(auth()->user())->get();
    return response()->json($projects);
}

}