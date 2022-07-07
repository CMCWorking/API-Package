<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class Category extends Model
{
    use HasFactory, FilterQueryString;

    protected $guarded = [];

    protected $filters = [
        'sort',
        'greater',
        'greater_or_equal',
        'less',
        'less_or_equal',
        'between',
        'not_between',
        'name',
        'slug',
        'keywords',
        'parent_id',
        'status',
    ];
}
