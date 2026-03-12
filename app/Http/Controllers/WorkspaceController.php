<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\User;
use Mail;
use App\Mail\InviteMail;
use Illuminate\Support\Str;
class WorkspaceController extends Controller
{
    use AuthorizesRequests;
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $workspace = Workspace::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . uniqid(),
            'owner_id' => auth()->id(),
        ]);

        $workspace->members()->attach(auth()->id(), ['role' => 'owner']);
        return response()->json($workspace, 201);
    }

    public function show(Workspace $workspace) {
        $this->authorize('view', $workspace);
        return $workspace->load(['articles', 'projects']);
    }

    public function update($user, Workspace $workspace, Request $request) {
        $this->authorize('update', $workspace);
        
        $data = $request->validate([
            'name' => 'sometimes|required',
            'slug' => 'sometimes|unique:workspaces,slug'
            . $workspace->id,
        ]);

        $workspace->update($data);
        return $user->owner;
    }


    /* Projects & Articles workspace */

   public function WorkspaceArticles(Workspace $workspace) {
    return $workspace->articles()->get();
}

public function WorkspaceProjects(Workspace $workspace) {
    return $workspace->projects()->get();
}
    // Inviting users by email feature

    public function invite(Request $request, Workspace $workspace, User $user)
    {
        // - if User is authenticated to manage authorize workspace management
        $this->authorize('manage', $workspace);

        if (!$workspace->members()->where('user_id', $user->id)->exists()) {
            return response()->json(
                ['message' => 'Dit is al een gebruiker.'],
                409,
                );    
        }
        

        // DEBUG: Mailing doesn't
        Mail::to($user->email)->send(new InviteMail());
        
        
        $workspace->members()->attach($user->id, ['role' => $request->role ?? 'member']);
            return response(['message' => 'Gebruiker is toegevoegd'], 200);       
    } 

    public function removeMember(Workspace $workspace, User $user) {
        $this->authorize('manage', $workspace);
        $workspace->members()->detach($user->id);
        return response()->json(['message' => 'Gebruiker is verwijderd'], 200);
    }

    public function destroy(Workspace $workspace) {
        $this->authorize('delete', $workspace);
        $workspace->delete(); 
        return response()->json(['message' => 'Jouw workspace is verwijderd.']);
    }
    
    public function index() {
            return auth()->user()->workspaces()->with('owner')->get();
        }
}