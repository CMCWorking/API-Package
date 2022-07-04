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

    protected $filterable = [
        'login_engine',
        'promotion' => 'receive_promotion',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class, 'customer_id');
    }

    public function filterPhone($query, $request)
    {
        $query->whereIn('phone', explode(",", trim($request)));

        return $query;
    }

    public function filterEmail($query, $request)
    {
        $query->whereIn('email', explode(",", trim($request)));

        return $query;
    }

    public function filterName($query, $request)
    {
        $query->whereIn('name', explode(",", $request));

        return $query;
    }
}
