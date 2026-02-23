<?php

namespace App\Http\Controllers;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Attachment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
class ArticleController extends Controller
{

    use AuthorizesRequests;
    public function index() {
        return
        Article::with('category')->get();
    }

    public function store(Request $request, Article $article)     {
        $this->authorize('store', $article);
        $data = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'summary' => 'nullable',
            'visibility' => 'string',
            'status' => 'string',
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
        $this->authorize('view', $article);   
        return response()->json($article->load('category'));
    }

    public function update(Request $request, Article $article) {

        $this->authorize('update', $article);
        $data = $request->validate([
            'title' => 'sometimes|required',
            'content' => 'sometimes|required',
            'summary' => 'sometimes|nullable',
            'visibility' => 'sometimes|required',
            'status' => 'sometimes|required',
            'category_id' => 'sometimes|required|exists:categories,id'
        ]);
        
        $article->update($data);
        return $article;
    }

    public function destroy(Article $article) {
        $this->authorize('deleted', $article);
        $article->delete();
        return response()->json(['deleted' => true]);
        }
}

