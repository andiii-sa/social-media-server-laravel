<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blog';

    protected $fillable = [
        'blogCategoryId', 'authorId', 'title', 'image', 'body'
    ];

    // realtion
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'id', 'blogCategoryId');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'id', 'authorId');
    }
}
