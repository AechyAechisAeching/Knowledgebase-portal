<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use APp\Models\User;
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'message' => 'Admin dashboard',
            'user' => $request->user(),
        ]);
    }
}