<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seeds extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'crop_id',
        'seed_name',
        'seed_type',
        'maturity_days',
        'season',
        'seed_description',
        'status',
    ];

    public function crop()
    {
        return $this->belongsTo(Crops::class, 'crop_id')->withTrashed();
    }
}
