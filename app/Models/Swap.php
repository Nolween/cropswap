<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Swap extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'image'];

    public function crops()
    {
        return $this->belongsToMany(Crop::class)->withPivot('quantity');
    }
}
