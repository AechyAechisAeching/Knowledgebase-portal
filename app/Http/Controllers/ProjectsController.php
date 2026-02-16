<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\ProjectRequest;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function store(ProjectRequest $request) {
        $project = Project::create($request->validated());
        
        return response()->json([
            'message' => 'Project has been added',
            'project' => $project,
        ], 201);
    }
}