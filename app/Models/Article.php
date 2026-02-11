<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    public const CREATED_AT = 'creation_date';
    protected $fillable = [
        'title',
        'content',
    ];
    public $timestamps = false;
    public const UPDATED_AT = 'updated_date';
}
