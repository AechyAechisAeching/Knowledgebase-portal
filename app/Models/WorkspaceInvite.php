<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkspaceInvite extends Model
{
    protected $fillable = [
        'workspace_id',
        'email',
        'token',
        'role',
        'expires_at'
    ];


    protected $casts = [
    'expires_at' => 'datetime'
    ];

    public function workspaces() {
        return $this->belongsTo(Workspace::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}
