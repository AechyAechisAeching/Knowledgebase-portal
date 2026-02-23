<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{

use AuthorizesRequests;
    public function destroy($id) {
    
     $user = User::findOrFail($id);
      $user->delete();

    return response()->json(
  ['message' => 'User has been deleted.']);
    }

    public function get($id) {
        
        $this->authorize('get', $id);
        $user = User::findOrFail($id);
        return response()->json($user);
    }
}
