<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{

use AuthorizesRequests;
    public function index() {
      $this->authorize('viewAny', User::class);
      $users = User::latest()->paginate(20);
      return response()->json($users);
    }
    public function show(User $user) {
      $this->authorize('view', $user);
      return response()->json($user);
  }

    public function store(UserRequest $request) {
      $this->authorize('create', User::class);
      $user = User::create($request->validated());
      return response()->json($user, 201);
    }

    public function update(UserRequest $request, User $user) {
      $this->authorize('update', $user);
      $user->update($request->validated());
      return response()->json($user);
    }

    public function destroy(User $user) {
      $this->authorize('delete', $user);
      $user->delete();
      return response()->json([
      'message' => 'Gebruiker is verwijderd.'
    ]);
    }
}

