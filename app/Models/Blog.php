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

    // relation
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blogCategoryId', 'id')
            ->select('blog_category.id', 'blog_category.name');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'authorId', 'id')
            ->select('users.id', 'users.username', 'users.name', 'users.photo');
    }
}
