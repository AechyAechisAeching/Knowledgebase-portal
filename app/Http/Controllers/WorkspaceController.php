<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use App\Models\WorkspaceInvite;
use App\Models\User;
use App\Mail\InviteMail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use App\Http\Requests\WorkspaceRequest;
use App\Http\Requests\WorkspaceUpdateRequest;
use App\Http\Requests\WorkspaceInviteRequest;
class WorkspaceController extends Controller
{
    use AuthorizesRequests;

    public function store(WorkspaceRequest $request)
    {
        $request->validated();
     

        $workspace = Workspace::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . uniqid(),
            'owner_id' => auth()->id(),
        ]);
 
        $workspace->members()->attach(auth()->id(), ['role' => 'owner']);
        return response()->json($workspace, 201);
    }
   public function show(Workspace $workspace)
    {
        $this->authorize('view', $workspace);
        return 
        $workspace->load(['articles', 'projects']);
    }

    public function update(Workspace $workspace, WorkspaceUpdateRequest $request)
    {
        $this->authorize('update', $workspace);
        $data = $request->validated();

        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']) . '-' . uniqid();
        }

        $workspace->update($data);
        return response()->json($workspace);
    }

    public function workspaceArticles(Workspace $workspace)
    {
        return $workspace->articles()->get();
    } 

    public function workspaceProjects(Workspace $workspace)
    {
        return $workspace->projects()->get();
    }

    public function invite(WorkspaceInviteRequest $request, Workspace $workspace)
    {
        $this->authorize('manage', $workspace); 
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();

        if ($user && $workspace->members()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'Deze gebruiker is al lid.'], 409);
        }

        WorkspaceInvite::where('workspace_id', $workspace->id)
            ->where('email', $data['email'])
            ->delete();

        $token = Str::random(64);

        WorkspaceInvite::create([
            'workspace_id' => $workspace->id,
            'email' => $data['email'],
            'token' => $token,
            'role' => $data['role'] ?? 'member',
            'expires_at' => now()->addDays(7),
        ]);

        $acceptUrl = URL::temporarySignedRoute(
            'workspace.invite.accept',
             now()->addDays(7),
            ['token' => $token]
        );

        Mail::to($data['email'])->send(new InviteMail($workspace, $acceptUrl));
        return 
        response()->json(['message' => 'Een uitnodiging is verstuurd.',
        ]);
    }

    public function acceptInvite(Request $request)
    {
        if (!$request->hasValidSignature()) {
            return response()->json(['message' => 'Ongeldige of verlopen uitnodiging.'], 403);
        }

        $invite = WorkspaceInvite::where('token', $request->token)
            ->where('expires_at', '>', now())
            ->firstOrFail();

        $user = User::where('email', $invite->email)->firstOrFail();
        $workspace = Workspace::findOrFail($invite->workspace_id);

        if (!$workspace->members()->where('user_id', $user->id)->exists()) {
            $workspace->members()->attach($user->id, ['role' => $invite->role]);
        }

        $invite->delete();
        return
        response()->json(['message' => 'Je bent toegevoegd aan de workspace.'], 200);
    }

    public function removeMember(Workspace $workspace, User $user)
    {
        $this->authorize('manage', $workspace);
        $workspace->members()->detach($user->id);
        return 
        response()->json(['message' => 'Gebruiker is verwijderd'], 200);
    }

    public function destroy(Workspace $workspace)
    {
        $this->authorize('delete', $workspace);
        $workspace->delete();
        return
        response()->json(['message' => 'Succesvol verwijderd.']);
    }

    public function index()
    {
        return auth()->user()->workspaces()->with('owner')->get();
    }
}