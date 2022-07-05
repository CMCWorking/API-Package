<?php

namespace App\Traits;

trait Sortable
{
    public function scopeSortable($query, $request)
    {
        $sort = ltrim($request, '-');
        $order = $request[0] === '-' ? 'desc' : 'asc';

        $query->orderBy($sort, $order);

        return $query;
    }
}
