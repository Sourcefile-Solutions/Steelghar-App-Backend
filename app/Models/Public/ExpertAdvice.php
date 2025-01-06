<?php

namespace App\Models\Public;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertAdvice extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getCreatedAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->timezone('Asia/Kolkata')->format('Y-m-d H:i a') : null;
    }
}
