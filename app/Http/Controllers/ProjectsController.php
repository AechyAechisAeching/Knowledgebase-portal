<?php
namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\ProjectsRequest;
class ProjectsController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        return Project::with(['category', 'article', 'workspace'])->latest()->get();
    }
    // Create

   
        public function store(ProjectsRequest $request){
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        return Project::create($data);
    }
    // Read
     public function show(Project $project)
     {
         $this->authorize('view', $project);
         return $project->load(['category', 'article', 'workspace']);
    }

    // Update
    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $data = $request->validated();
        $project->update($data);
        // return response()->json($project);
            return $project;
        }
    // Delete
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

     public function myProjects() {
        return
        Project::with(['category', 'article', 'workspace'])->where('user_id', auth()->id())
        ->get();
    }
}