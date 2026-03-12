<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attachment;
class Article extends Model
{

    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'content',
        'summary',
        'status',
        'project_id',
        'category_id',
        'workspace_id',
        'visibility',
    ];

    protected $casts = [
        'visibility' => 'string',
        'status' => 'string'
    ];
    public function workspace() {
        return $this->belongsTo(Workspace::class);
    }

    public function project(){
    return $this->belongsTo(Project::class);
}
    public function attachments() {
        return 
        $this->hasMany(Attachment::class);
        
    }
    public function category()
{
    return $this->belongsTo(Category::class);
}
    public function tags() {

       return $this->belongsToMany(Tag::class);
    }


  public function scopeVisibleTo($query, $user = null)
{
    if ($user && $user->role === 'admin') {
        return $query;
    }
    
    return $query->where('visibility', 'public')->where('status', 'published');
}
}
