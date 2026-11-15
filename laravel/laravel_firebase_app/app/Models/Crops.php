<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Crops extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'crop_name',
        'crop_season',
        'crop_type',
        'variety',
        'sowing_method',
        'irrigation',
        'fertilizers',
        'plant_protection',
        'deficiency',
        'weeds',
        'advisory',
        'crop_image',
        'status',
    ];

    // public function seeds()
    // {
    //     return $this->hasMany(Seeds::class, 'crop_id');
    // }
}
