<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'father_name',
        'reg_no',
        'english',
        'math',
        'punjabi',
        'status'
    ];
}
