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
        public function store(ProjectsRequest $request){
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        return Project::create($data);
    }
        public function show(Project $project)
    {
        $this->authorize('view', $project);
        if ($project->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Onbevoegd.'], 403);
        }
        return $project->load(['category', 'article', 'workspace']);
    }
        public function update(Request $request, Project $project)
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
        public function myProjects() {
        return
        Project::with(['category', 'article', 'workspace'])->where('user_id', auth()->id())
        ->get();
    }
}