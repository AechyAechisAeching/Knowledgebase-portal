<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class CategoryController extends Controller
{

use AuthorizesRequests;
  public function index() {
    return
    Category::withCount('projects')->get();
  }
  public function store(Request $request)
  {
    
    $data = $request->validate([
      'name' => 'required',
      'slug' => 'unique:categories,slug'
    ]);
      $category = Category::create($data);

      // dd($data);
      return response()->json($category, 201);
      
    }

  public function show(Category $category) {
  $this->authorize('view', $category);  
  return $category->load('projects');
  }

  public function update(Request $request, Category $category)
  {
    $this->authorize('update', $category);
    $data = $request->validate([
      'name' => 'sometimes|required',
      'slug' => 'sometimes|unique:categories,slug,'
      . $category->id,
    ]);

    $category->update($data);
    return $category;
  }

  public function destroy(Category $category)
  {
    $this->authorize('delete', $category);
    $category->delete();
    return response()->json([
      'message' => 'Deleted'
    ]);
  }

  public function AdminIndex() {
    return Category::withCount('projects')->get();
    }

}