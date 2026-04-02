<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{

use AuthorizesRequests;
    public function destroy($id) {
    
     $user = User::findOrFail($id);
      $user->delete();

    return response()->json(
    ['message' => 'Gebruiker is verwijderd.']);
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

