<?php

namespace App\Http\Controllers;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
      public function store(ArticleRequest $request)
    {
        $article = Article::create($request->validated());
        return response()->json([
            'message' => 'Article Added',
            'article'=> $article
        ],201);
    }

}
