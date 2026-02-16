<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
class CategoryController extends Controller
{
  public function index() {
    return
    Category::withCount('articles')->get();
  }
  public function store(Request $request)
  {
    $data = $request->validate([
      'name' => 'required',
      'slug' => 'required|unique:categories,slug,'
    ]);

      $category = Category::create($data);

      return response()->json($category, 201);
    }

  public function show(Category $category) {
    return $category->load('articles');
  }

  public function update(Request $request, Category $category)
  {
    $data = $request->validate([
      'name' => 'sometimes|required',
      'slug' => 'sometimes|required|unique|categories,slug,'
      . $category->id
    ]);
    $category->update($data);
    return $category;
  }
  public function destroy(Category $category) {
    $category->delete();
    return response()->json([
      'message' => 'Deleted'
    ]);
  }
}