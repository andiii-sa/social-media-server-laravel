<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blog_category';

    protected $fillable = [
        'name'
    ];

    // realtion
    public function categories()
    {
        return $this->hasMany(Blog::class, 'blogCategoryId', 'id');
    }
}
