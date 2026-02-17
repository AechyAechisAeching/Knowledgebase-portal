<?php

namespace App\Http\Controllers;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Attachment;
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

    public function storeAttachment(Request $request): JsonResponse
    {
        
        $data = $request->validate([
            'file' => 'required',
            'article_id' => 'required|exists:articles,id'
        ]);
                
        
        
        
        new JsonResponse($data);
        $file = Storage::put('attachments', $data['file']);
        $attachment = Attachment::create(
            [
                'article_id' => $data['article_id'],
                'path' => $file,
                'mime' => $data['file']->getMimeType(),
                'original_name' => $data['file']->getClientOriginalName(),
                'size' => $data['file']->getSize()
            ],
        );
        return new JsonResponse($attachment);
    }

    public function show(Article $article) {
        
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

