<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\CategoryRequest;
class CategoryController extends Controller
{
  
use AuthorizesRequests;
  public function index() {
    return
    Category::withCount('projects')->latest()->get();
  }
  public function store(CategoryRequest $request)
  {
    $data = $request->validated();
      
    return 
    Category::create($data);

      // dd($data);
      
      
    }

  public function show(Category $category) {
  $this->authorize('view', $category);  
  return $category->load('projects');
  }

public function update(Request $request, Category $category)
{
    $this->authorize('update', $category);

    $data = $request->validate([
        'name' => 'sometimes|required|string',
        'slug' => [
            'sometimes',
            'required',
            Rule::unique('categories', 'slug')->ignore($category->id),
        ],
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