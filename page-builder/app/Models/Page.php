<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['title', 'slug', 'layout_data', 'status'];

    protected $casts = [
        'layout_data' => 'array',
    ];
}