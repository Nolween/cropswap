<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogArticleComment extends Pivot
{

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'blog_article_id',
        'content',
        'user_id',
        'created_at',
        'updated_at',
    ];

    public function blogArticle(): BelongsTo
    {
        return $this->belongsTo(BlogArticle::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
