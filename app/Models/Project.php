<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'projectname',
        'description',
        'slug',
        'user_id',
        'category_id',
        'workspace_id',
    ];
  
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
   
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
   
    public function article(): HasMany
    {
        return $this->hasMany(Article::class);
    }
    // public function articles(): HasMany
    // {
    //     return $this->hasMany(Article::class);
    // }
    public function workspace(): BelongsTo {
        return $this->belongsTo(Workspace::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($project) {
            $project->slug = Str::slug($project->projectname);
        });
    }
}
