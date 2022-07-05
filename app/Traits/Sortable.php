<?php

namespace App\Traits;

trait Sortable
{
    public function scopeSortable($query, $request)
    {
        if (empty($request)) {
            return $query;
        }

        $sort = ltrim($request, '-');
        $order = $request[0] === '-' ? 'desc' : 'asc';

        $query->orderBy($sort, $order);

        return $query;
    }
}
