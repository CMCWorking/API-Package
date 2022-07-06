<?php

namespace App\Models;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class CustomerInformation extends Model
{
    protected $guarded = [];
    use HasFactory, FilterQueryString;

    protected $table = 'customer_informations';

    protected $filterable = [
        'login_engine',
        'promotion' => 'receive_promotion',
    ];

    protected $filters = [
        'sort',
        'between',
        'name',
        'email',
        'phone',
        'login_engine',
        'receive_promotion',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class, 'customer_id');
    }
}
