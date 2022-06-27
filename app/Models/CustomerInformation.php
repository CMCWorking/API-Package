<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerInformation extends Model
{
    protected $guarded = [];
    use HasFactory, Filterable;

    protected $table = 'customer_informations';

    /* This is a list of the columns that you can filter by. */
    protected $filterable = [
        'login_engine',
        /* A way to map the filter name to the column name. */
        'promotion' => 'receive_promotion',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class, 'customer_id');
    }

    public function filterPhone($query, $request)
    {
        if (count(explode(",", trim($request))) >= 2) {
            $phone = explode(",", trim($request));
            $query->whereIn('phone', $phone);
        } else {
            $query->where('phone', '%' . $request . '%');
        }

        return $query;
    }

    public function filterEmail($query, $request)
    {
        if (count(explode(",", trim($request))) >= 2) {
            $phone = explode(",", trim($request));
            $query->whereIn('email', $phone);
        } else {
            $query->where('email', '%' . $request . '%');
        }

        return $query;
    }

    public function filterName($query, $request)
    {
        if (count(explode(",", $request)) >= 2) {
            $phone = explode(",", $request);
            $query->whereIn('name', $phone);
        } else {
            $query->where('name', '%' . $request . '%');
        }

        return $query;
    }
}
