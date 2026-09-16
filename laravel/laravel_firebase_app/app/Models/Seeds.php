<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seeds extends Model
{
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
        return $this->belongsTo(Crops::class, 'crop_id');
    }
}
