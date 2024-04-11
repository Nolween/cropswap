<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CropSwap extends Model
{
    use HasFactory;

    // Define const for quantity, 0, 1 and 2
    const NONE_QUANTITY = 0;
    const FEW_QUANTITY  = 1;
    const MANY_QUANTITY = 2;

    const QUANTITIES = [
        self::NONE_QUANTITY,
        self::FEW_QUANTITY ,
        self::MANY_QUANTITY,
    ];

    protected $fillable = ['crop_id', 'swap_id', 'quantity'];

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }

    public function swap()
    {
        return $this->belongsTo(Swap::class);
    }


}
