<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Crop extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'image',
        'created_at',
        'updated_at',
        'deleted_at',
        'user_id',
        'latitude',
        'longitude',
        'is_active',
        'is_permaculture',
        'is_shared',
        'is_pesticide_free',
        'is_private',
        'is_professional',
        'can_give',
        'can_swap',
        'can_sell',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function swaps()
    {
        return $this->belongsToMany(Swap::class)->withPivot('quantity');
    }

}
