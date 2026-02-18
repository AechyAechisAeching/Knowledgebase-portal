<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Attachment;
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
        'visibility',
        'category_id'
    ];

    protected $casts = [
        'visibility' => 'string',
        'status' => 'string'
    ];

    public function attachments() {
        return 
        $this->hasMany(Attachment::class);
        
    }
    public function tags() {

       return $this->belongsToMany(Tag::class);
    }

        public function category() {
         return $this->belongsTo(Category::class);
        
    }
}
