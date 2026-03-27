<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleUpdateRequest;
use Arr;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Attachment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Project;
use App\Models\Article;
use App\Http\Requests\ArticleRequest;
use App\Http\Requests\FeedbackRequest;
class ArticleController extends Controller
{

    use AuthorizesRequests;
    public function index() {
        $this->authorize('viewAny', Article::class);        
        $articles = Article::where('status', 'published')
        ->latest()->get();
        return response()->json($articles);
    }

   public function store(ArticleRequest $request) {
    $this->authorize('create', [Article::class, $request->project_id]);
    $data = $request->validated();
    $article = Article::create(Arr::except($data, ['attachments']));

    if ($request->hasFile('attachments')) {
        foreach ($request->file('attachments') as $file) {
            $path = Storage::put('attachments', $file);

            Attachment::create([
                'article_id'    => $article->id,
                'path'          => $path,
                'mime'          => $file->getMimeType(),
                'original_name' => $file->getClientOriginalName(),
                'size'          => $file->getSize(),
            ]);
        }
    }

    return response()->json($article->load('attachments'), 201);
}

    public function show(Article $article) { 
    $this->authorize('view', $article);
     $article = Article::where('status', 'published')
     ->findOrFail($article->id);

    return response()->json($article);
    }

    public function update(ArticleUpdateRequest $request, Article $article) {

        $this->authorize('update', $article);
        $article->update($request->validated());

        return $article->load(['project', 'category', 'attachments']);
    }

    public function destroy(Article $article) {
        $this->authorize('delete', $article);
        $article->delete();
        return response()->json(['delete' => true]);
        }



    public function showPublished(Project $project, Article $article) {
    abort_if($article->project_id !== $project->id, 404);
    abort_if($article->status !== 'published', 403);
    abort_if($article->visibility !== 'public', 403);

    return response()->json($article->load(['project', 'category', 'attachments']));
}

    public function search(Project $project, Request $request) {
        $this->authorize('view', $project);

      $keyword = $request->input('keyword');
      if (!$keyword) return response()->json([]);

     $articles = Article::visibleTo(auth()->user())
     ->with(['project', 'category', 'attachments'])
    ->where('project_id', $project->id)
      ->where('status', 'published') 
        ->where(function ($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('content', 'like', "%{$keyword}%")
              ->orWhere('summary', 'like', "%{$keyword}%");
        })->get();
        return response()->json($articles);
}

    public function projectArticles(Project $project) {
    $this->authorize('view', $project);
    $articles = Article::visibleTo(auth()->user())
        ->where(['project', 'category', 'attachments'])
        ->where('project_id', $project->id)
        ->get();
        return response()->json($articles);
}
    public function storeFeedback(FeedbackRequest $request, Article $article) {
    $this->authorize('view', $article);
    $data = $request->validated();
    $feedback = $article->feedbacks()->updateOrCreate(
        ['user_id' => auth()->id()],    
        ['helpful' => $data['helpful'],
         'comment' => $data['comment'],
    ]);
return response()->json($feedback, 201);
}
    public function AdminIndex(Request $request)
    {
        $query = Article::visibleTo(auth()->user())
        ->with(['project', 'category', 'attachments']);

        if ($request->user_id) {
            $query->whereHas('project', function ($q) use ($request) {
                $q->where('user_id', $request->user_id);
            });
        }

        return response()->json($query->latest()->get());
    }
}

