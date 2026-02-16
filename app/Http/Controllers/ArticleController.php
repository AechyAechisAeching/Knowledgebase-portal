<?php

namespace App\Http\Controllers;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index() {
        return
        Article::with('category')->get();
    }

    public function store(Request $request) {
        $data = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'summary' => 'nullable',
            'category_id' => 'required|exists:categories,id'
        ]);
        return Article::create($data);
    }
    public function show(Article $article) {
        return
        $article->load('category');
    }

    public function update(Request $request, Article $article) {
        $data = $request->validate([
            'title' => 'sometimes|required',
            'content' => 'sometimes|required',
            'summary' => 'sometimes|nullable',
            'category_id' => 'sometimes|required|exists:categories,id'
        ]);
        $article->update($data);
        return $article;
    }

    public function destroy(Article $article) {
        $article->delete();
        return response()->json([
            'message' => 'Deleted'
        ]);

        }
    
}

