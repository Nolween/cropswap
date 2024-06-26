<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogArticle extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Timestamp;

    protected $fillable = [
        'title',
        'content',
        'image',
        'tags',
        'user_id',
        'created_at',
        'updated_at',
    ];

    // cast the tags to an array
    protected $casts = [
        'tags' => 'array',
    ];

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments() :HasMany
    {
        return $this->hasMany(BlogArticleComment::class)->orderBy('created_at', 'desc');
    }

}
