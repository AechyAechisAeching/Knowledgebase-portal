<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    protected $fillable = ['name', 'slug', 'owner_id'];

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members() {
        return $this->belongsToMany(User::class, 'user_workspace')
        ->withPivot('role')->withTimestamps(); 
    }
    public function WorkspaceInvite() {
        return $this->hasMany(WorkspaceInvite::class);
    }
    public function Articles() {
        return
        $this->hasMany(Article::class);
    }

    public function Projects() {
        return
        $this->hasMany(Project::class);
    }
}
