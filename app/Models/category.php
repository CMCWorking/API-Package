<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Filterable, Sortable;

    protected $guarded = [];

    protected $filterable = [
        'name',
        'slug',
        'keywords',
        'parent_id',
        'status',
    ];
}
