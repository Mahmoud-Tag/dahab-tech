<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'category',
        'catIcon',
        'desc',
        'fullDesc',
        'image',
        'tags',
        'year',
        'type',
        'downloads',
        'downloadUrl',
        'features',
    ];

    protected $casts = [
        'tags' => 'array',
        'features' => 'array',
    ];
}
