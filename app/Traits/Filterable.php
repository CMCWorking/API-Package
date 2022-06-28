<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Filterable
{
    public function scopeFilter($query, $request)
    {
        $params = $request;

        foreach ($params as $field => $value) {
            $method = 'filter' . Str::studly($field);

            if ($value === '') {
                continue;
            }

            if (method_exists($this, $method)) {
                $this->{$method}($query, $value);
                continue;
            }

            if (empty($this->filterable) || !in_array($field, $this->filterable)) {
                continue;
            }

            if (in_array($field, $this->filterable)) {
                $query->where($this->table . '.' . $field, 'like', '%' . $value . '%');

                continue;
            }

            if (key_exists($field, $this->filterable)) {
                $query->where($this->table . '.' . $this->filterable[$field], 'like', '%' . $value . '%');

                continue;
            }
        }

        return $query;
    }
}
