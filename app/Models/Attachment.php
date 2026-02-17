<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Attachment extends Model
{   
    use HasFactory;

    protected $fillable = [
            'article_id',
            'path',
            'mime',
            'original_name',
            'size',
        ];


    public function article() {

      $this->belongsTo(Article::class);
    }

}
