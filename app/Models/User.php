<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[ObservedBy(UserObserver::class)]
class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'last_connection_date',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }


    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function blogArticles(): HasMany
    {
        return $this->hasMany(BlogArticle::class);
    }

    public function blogArticleComments(): HasMany
    {
        return $this->hasMany(BlogArticleComment::class);
    }

    public function sentMessages(): HasMany
    {
        return $this->hasMany(UserMessage::class, 'sender_id');
    }

    public function receivedMessages(): HasMany
    {
        return $this->hasMany(UserMessage::class, 'receiver_id');
    }

    public function reportedMessages(): HasMany
    {
        return $this->sentMessages()
                    ->where('is_reported', true);
    }

    public function crop(): HasMany
    {
        return $this->hasMany(Crop::class);
    }
}
