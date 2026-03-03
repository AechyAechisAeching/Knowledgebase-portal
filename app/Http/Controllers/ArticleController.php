<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Attachment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Project;
use App\Models\Article;

class ArticleController extends Controller
{

    use AuthorizesRequests;
    public function index() {
        return
        Article::visibleTo(auth()->user())->latest()->get();
    }

    public function store(Request $request)     {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'summary' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'category_id' => 'nullable|exists:categories,id',
            'visibility' => 'required|in:public,private',
            'status' => 'required|in:draft,published,archived',
            
        ]);
        return Article::create($data);
    }

    public function storeAttachment(Request $request): JsonResponse
    {   
        $data = $request->validate([
            'file' => 'required|file|max:10240',
            'article_id' => 'required|exists:articles,id'
        ]);
                
        
        
        
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
    // ! REMEMBER THIS   
    if (auth()->user()->role !== 'admin' && $article->visibility === 'private') {
        abort(403, 'This article is unavailable.');
    }
    return $article->load(['project', 'category']);
    }

    public function update(Request $request, Article $article) {

        $this->authorize('update', $article);
        $data = $request->validate([
            'title' => 'sometimes|required',
            'content' => 'sometimes|required',
            'summary' => 'sometimes|nullable',
            'visibility' => 'sometimes|required',
            'status' => 'sometimes|required',
            'project_id' => 'sometimes|required|exists:projects,id',
            'category_id' => 'sometimes|required|exists:categories,id'
        ]);
        
        $article->update($data);
        return $article;
    }

    public function destroy(Article $article) {
        $this->authorize('delete', $article);
        $article->delete();
        return response()->json(['delete' => true]);
        }



        // TODOS------------------------------------------------------------------------------------------------------------------------
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

        // TODOS------------------------------------------------------------------------------------------------------------------------

    public function AdminIndex(Request $request) {
        $query = Article::with(['category', 'project', 'article']);
        if ($request->user_id) {
        $query->where('user_id', $request->user_id);
         };

         return Article::with(['category', 'project'])->latest()->get();
    }
    //     public function AdminIndex()
    // {
    //     return Article::with(
    //     ['project', 'category', 'article'])->latest()->get();
    // }

}

