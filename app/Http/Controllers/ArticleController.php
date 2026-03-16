<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Attachment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Project;
use App\Models\Article;
use App\Models\Workspace;
use App\Http\Requests\ArticleRequest;

class ArticleController extends Controller
{

    use AuthorizesRequests;
    public function index() {
        return
        Article::visibleTo(auth()->user())->latest()->get();
    }

    public function store(ArticleRequest $request)     {
    $data = $request->validated();

     return Article::create($data);
    }

    public function storeAttachment(Request $request): JsonResponse
    {   
        $data = $request->validated();
                
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
    return $article->load(['project', 'category']);
    }

    public function update(ArticleUpdateRequest $request, Article $article) {

        $this->authorize('update', $article);
        $article->update($request->validated());

        return $article;
    }

    public function destroy(Article $article) {
        $this->authorize('delete', $article);
        $article->delete();
        return response()->json(['delete' => true]);
        }



    public function projectArticles(Project $project)
    {
        $query = $project->article();
         if (auth()->user()->role === 'admin') {
            $query->whereIn('status', ['draft', 'published', 'archived'])
                ->whereIn('visibility', ['public', 'private']);
        } else {
            $query->where('status', 'published' )
            ->where('visibility', 'public'); 
        }
        return $query->get();
    }

    

    public function AdminIndex(Request $request) {
        $query = Article::with(['category', 'project', 'article']);
        if ($request->user_id) {
        $query->where('user_id', $request->user_id);
         };

         return $query->latest()->get();
    }
}

