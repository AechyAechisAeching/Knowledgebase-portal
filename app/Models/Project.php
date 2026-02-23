<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'category_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function category() {
        return
        $this->belongsTo(Category::class);
    }

        protected static function boot()
{
    parent::boot();

    static::saving(function ($project) {
        $project->slug = Str::slug($project->projectname);
    });
}

}


